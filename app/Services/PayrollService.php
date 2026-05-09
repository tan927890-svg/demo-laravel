<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Kpi;
use App\Models\KpiTier;
use App\Models\Order;
use App\Models\Payroll;
use App\Models\SalaryHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    /**
     * Tính lương cho một nhân viên.
     * Nếu đã approved → không tính lại.
     */
    public function calculateForUser(User $user, int $month, int $year): Payroll
    {
        $existing = Payroll::where('user_id', $user->id)
            ->where('month', $month)->where('year', $year)->first();

        if ($existing && $existing->isApproved()) {
            return $existing;
        }

        // 1. Lương cứng
        $baseSalary = SalaryHistory::getForMonth($user->id, $month, $year);

        // 2. Tổng hoa hồng — lấy từ orders da_chot_don trong tháng
        //    commission_amount được tính sẵn khi Manager chốt đơn
        $totalCommission = (int) Order::where('assigned_to', $user->id)
            ->where('consultation_status', 'da_chot_don')
            ->whereYear('closed_at', $year)
            ->whereMonth('closed_at', $month)
            ->sum('commission_amount');

        // 3. % KPI + thưởng KPI
        [$kpiBonus, $kpiPercent] = $this->calculateKpiBonus($user->id, $month, $year, $baseSalary);

        // 4. Ngày công — đếm số ngày làm đủ 8 tiếng
        $workingDays      = 30;
        $validDays        = Attendance::countValidDays($user->id, $month, $year);
        $attendanceSalary = round(($validDays / $workingDays) * $baseSalary);

        // 5. Tăng ca — giờ tăng ca × đơn giá admin nhập
        $overtimeHours      = Attendance::countOvertimeHours($user->id, $month, $year);
        $overtimeRate       = $existing?->overtime_rate ?? 0;
        $overtimeAllowance  = round($overtimeHours * $overtimeRate);

        $totalSalary = $attendanceSalary + $totalCommission + $kpiBonus + $overtimeAllowance;

        return Payroll::updateOrCreate(
            ['user_id' => $user->id, 'month' => $month, 'year' => $year],
            [
                'base_salary'        => $baseSalary,
                'total_commission'   => $totalCommission,
                'kpi_bonus'          => $kpiBonus,
                'kpi_percent'        => $kpiPercent,
                'valid_days'         => $validDays,
                'working_days'       => $workingDays,
                'overtime_hours'     => $overtimeHours,
                'overtime_rate'      => $overtimeRate,
                'overtime_allowance' => $overtimeAllowance,
                'total_salary'       => $totalSalary,
                'status'             => 'draft',
            ]
        );
    }

    /**
     * Tính lương toàn bộ staff + manager trong tháng.
     */
    public function calculateForAllStaff(int $month, int $year): array
    {
        $staff   = User::whereIn('role', ['staff', 'manager'])->get();
        $results = [];

        DB::transaction(function () use ($staff, $month, $year, &$results) {
            foreach ($staff as $user) {
                $results[] = $this->calculateForUser($user, $month, $year);
            }
        });

        return $results;
    }

    /**
     * Admin chốt bảng lương.
     */
    public function approve(Payroll $payroll, User $admin, ?string $note = null): void
    {
        abort_unless($payroll->isDraft(), 422, 'Chỉ chốt được khi ở trạng thái nháp.');
        abort_unless($admin->isAdmin(), 403);

        $payroll->update([
            'status'      => 'approved',
            'approved_by' => $admin->id,
            'approved_at' => now(),
            'note'        => $note,
        ]);
    }

    /**
     * Mở lại bảng lương đã chốt để tính lại.
     */
    public function reopen(Payroll $payroll, User $admin): void
    {
        abort_unless($admin->isAdmin(), 403);

        $payroll->update([
            'status'      => 'draft',
            'approved_by' => null,
            'approved_at' => null,
            'note'        => null,
        ]);
    }

    // ── Private ──

    /**
     * Tính % KPI và thưởng KPI cho nhân viên.
     *
     * Logic:
     *   - Có KPI target_revenue  → % = doanh số thực / target × 100
     *   - Không có KPI target    → fallback: % = đơn đã chốt / tổng đơn × 100
     *   - Thưởng tính qua KpiTier; fallback bonus tính trên lương cứng
     */
    private function calculateKpiBonus(int $userId, int $month, int $year, float $baseSalary): array
    {
        // ── Đếm tổng đơn & đơn đã chốt trong tháng ──
        $totalOrders = Order::where('assigned_to', $userId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $closedOrders = Order::where('assigned_to', $userId)
            ->where('consultation_status', 'da_chot_don')
            ->whereYear('closed_at', $year)
            ->whereMonth('closed_at', $month)
            ->count();

        // ── Lấy KPI target ──
        $kpi = Kpi::where('user_id', $userId)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        // ── Tính % KPI ──
        $actualRevenue = null;

        if ($kpi && $kpi->target_revenue > 0) {
            // Có target → dùng doanh số thực / target
            $actualRevenue = (float) Order::where('assigned_to', $userId)
                ->where('consultation_status', 'da_chot_don')
                ->whereYear('closed_at', $year)
                ->whereMonth('closed_at', $month)
                ->sum('sale_price');

            $percent = round(($actualRevenue / (float) $kpi->target_revenue) * 100, 1);

        } elseif ($totalOrders > 0) {
            // Không có target → fallback: % chốt đơn
            $percent = round(($closedOrders / $totalOrders) * 100, 1);

        } else {
            // Không có đơn nào
            return [0, 0.0];
        }

        // ── Tính thưởng theo KpiTier ──
        $tier = KpiTier::findForPercent($percent);
        if (!$tier) {
            return [0, $percent]; // Có % nhưng chưa đạt mốc thưởng
        }

        if ($kpi && $kpi->target_revenue > 0 && $actualRevenue !== null) {
            // Có target → bonus tính trên doanh số thực
            $bonus = $tier->calculateBonus($actualRevenue, (float) $kpi->target_revenue);
        } else {
            // Fallback → bonus tính trên lương cứng
            $bonus = $tier->calculateBonus($baseSalary, $baseSalary);
        }

        return [(int) $bonus, $percent];
    }
}
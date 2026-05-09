<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PayrollExport;
use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\SalaryHistory;
use App\Models\User;
use App\Services\PayrollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    public function __construct(private PayrollService $payrollService) {}

    /**
     * Danh sách bảng lương theo tháng.
     */
    public function index(Request $request)
    {
        $month = $request->integer('month', now()->month);
        $year  = $request->integer('year',  now()->year);

        $payrolls = Payroll::with('user')
            ->where('month', $month)
            ->where('year',  $year)
            ->orderByDesc('total_salary')
            ->get();

        $staff = User::whereIn('role', ['staff', 'manager'])
            ->with(['salaryHistories' => fn($q) => $q
                ->orderByDesc('effective_year')
                ->orderByDesc('effective_month')
                ->limit(1)
            ])
            ->orderBy('name')
            ->get();

        return view('admin.payroll.index', compact('payrolls', 'month', 'year', 'staff'));
    }

    /**
     * Chi tiết một bảng lương.
     */
    public function show(Payroll $payroll)
    {
        $payroll->load('user', 'approver');
        $user = $payroll->user;

        $staff = User::whereIn('role', ['staff', 'manager'])
            ->with(['salaryHistories' => fn($q) => $q
                ->orderByDesc('effective_year')
                ->orderByDesc('effective_month')
                ->limit(1)
            ])
            ->orderBy('name')
            ->get();

        return view('admin.payroll.show', compact('payroll', 'user', 'staff'));
    }

    /**
     * Admin tính lương cho toàn bộ staff.
     */
    public function calculate(Request $request)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year'  => 'required|integer|min:2020|max:2100',
        ]);

        $payrolls = $this->payrollService->calculateForAllStaff(
            $request->integer('month'),
            $request->integer('year')
        );

        return redirect()
            ->route('admin.payroll.index', ['month' => $request->month, 'year' => $request->year])
            ->with('success', 'Đã tính lương cho ' . count($payrolls) . ' nhân viên.');
    }

    /**
     * Admin chốt bảng lương (khóa).
     */
    public function approve(Request $request, Payroll $payroll)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $request->validate(['note' => 'nullable|string|max:500']);

        $this->payrollService->approve($payroll, Auth::user(), $request->note);

        return back()->with('success', 'Đã chốt bảng lương thành công.');
    }

    /**
     * Admin mở lại bảng lương đã chốt.
     */
    public function reopen(Payroll $payroll)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $this->payrollService->reopen($payroll, Auth::user());

        return back()->with('success', 'Đã mở lại bảng lương để tính lại.');
    }

    /**
     * Admin xoá bảng lương (chỉ trạng thái nháp).
     */
    public function destroy(Payroll $payroll)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        abort_unless($payroll->isDraft(), 422, 'Chỉ xoá được bảng lương ở trạng thái nháp.');

        $payroll->delete();

        return back()->with('success', 'Đã xoá bảng lương.');
    }

    /**
     * Xuất Excel toàn bộ bảng lương tháng.
     */
    public function export(Request $request)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $month = $request->integer('month', now()->month);
        $year  = $request->integer('year',  now()->year);

        $filename = "bang-luong-thang-{$month}-{$year}.xlsx";

        return Excel::download(new PayrollExport($month, $year), $filename);
    }

    // ── Quản lý lương cứng ──

    /**
     * @deprecated Không dùng nữa — form nhập lương cứng đã được
     *             tích hợp thẳng vào trang index. Giữ lại để tránh
     *             lỗi route nếu còn link cũ trong code.
     */
    public function salaryIndex()
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        return redirect()->route('admin.payroll.index')
            ->with('success', 'Quản lý lương cứng đã được tích hợp vào trang bảng lương.');
    }

    public function storeSalary(Request $request)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $data = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'base_salary'     => 'required|integer|min:0',
            'effective_month' => 'required|integer|min:1|max:12',
            'effective_year'  => 'required|integer|min:2020',
            'note'            => 'nullable|string|max:255',
        ]);

        SalaryHistory::updateOrCreate(
            [
                'user_id'         => $data['user_id'],
                'effective_month' => $data['effective_month'],
                'effective_year'  => $data['effective_year'],
            ],
            [
                'base_salary' => $data['base_salary'],
                'created_by'  => Auth::id(),
                'note'        => $data['note'] ?? null,
            ]
        );

        return back()->with('success', 'Đã cập nhật lương cứng thành công.');
    }

    /**
     * Cập nhật lương cứng trực tiếp trên trang chi tiết bảng lương.
     * Chỉ cho phép khi bảng lương chưa chốt (status != approved).
     */
    public function updateBaseSalary(Request $request, Payroll $payroll)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        abort_if($payroll->status === 'approved', 422, 'Không thể sửa bảng lương đã chốt.');

        $data = $request->validate([
            'base_salary' => 'required|integer|min:0',
        ]);

        $payroll->base_salary  = $data['base_salary'];
        $payroll->total_salary = $this->recalculateTotalSalary($payroll);
        $payroll->save();

        // Đồng thời lưu vào lịch sử lương để các tháng sau dùng
        SalaryHistory::updateOrCreate(
            [
                'user_id'         => $payroll->user_id,
                'effective_month' => $payroll->month,
                'effective_year'  => $payroll->year,
            ],
            [
                'base_salary' => $data['base_salary'],
                'created_by'  => Auth::id(),
                'note'        => 'Cập nhật từ trang chi tiết bảng lương',
            ]
        );

        return back()->with('success', 'Đã cập nhật lương cứng thành công.');
    }

    /**
     * Cập nhật đơn giá tăng ca và tính lại tiền tăng ca + tổng lương.
     * Giờ tăng ca (overtime_hours) lấy từ GPS chấm công, đã tổng hợp sẵn.
     * Tiền tăng ca lưu vào cột overtime_allowance.
     */
    public function updateOvertimeRate(Request $request, Payroll $payroll)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        abort_if($payroll->status === 'approved', 422, 'Không thể sửa bảng lương đã chốt.');

        $data = $request->validate([
            'overtime_rate' => 'required|numeric|min:0',
        ]);

        $rate  = (int) $data['overtime_rate'];
        $hours = (float) ($payroll->overtime_hours ?? 0);

        $payroll->overtime_rate        = $rate;
        $payroll->overtime_allowance   = (int) round($hours * $rate);
        $payroll->total_salary         = $this->recalculateTotalSalary($payroll);
        $payroll->save();

        return back()->with('success', 'Đã cập nhật đơn giá tăng ca và tính lại lương.');
    }

    // ── Helper ──

    /**
     * Tính lại tổng lương từ tất cả các thành phần.
     * Dùng chung cho updateBaseSalary và updateOvertimeRate.
     */
    private function recalculateTotalSalary(Payroll $payroll): int
    {
        $workingDays = $payroll->working_days ?: 30;
        $validDays   = $payroll->valid_days   ?? 0;
        $base        = $payroll->base_salary  ?? 0;

        $attendanceSalary = $workingDays > 0
            ? (int) round(($validDays / $workingDays) * $base)
            : 0;

        return $attendanceSalary
             + (int) ($payroll->total_commission   ?? 0)
             + (int) ($payroll->kpi_bonus          ?? 0)
             + (int) ($payroll->overtime_allowance ?? 0);
    }
}
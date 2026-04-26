<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AttendanceExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    WithStyles,
    ShouldAutoSize
{
    protected ?int $userId;
    protected ?string $month; // format: Y-m

    public function __construct(?int $userId = null, ?string $month = null)
    {
        $this->userId = $userId;
        $this->month  = $month;
    }

    public function collection()
    {
        $query = Attendance::with('user')->orderByDesc('work_date');

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        if ($this->month) {
            $query->whereYear('work_date', substr($this->month, 0, 4))
                  ->whereMonth('work_date', substr($this->month, 5, 2));
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'STT',
            'Nhân Viên',
            'Email',
            'Vai Trò',
            'Ngày',
            'Check-in',
            'Check-out',
            'Giờ Làm',
            'Địa chỉ Check-in',
            'Địa chỉ Check-out',
            'Trạng Thái',
        ];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;

        $status = 'Chưa check-in';
        if ($row->check_in_at && !$row->check_out_at) {
            $status = 'Đang làm việc';
        } elseif ($row->check_in_at && $row->check_out_at) {
            $status = 'Hoàn thành';
        }

        return [
            $i,
            $row->user->name ?? '—',
            $row->user->email ?? '—',
            match($row->user->role ?? '') {
                'admin'   => 'Admin',
                'manager' => 'Manager',
                'staff'   => 'Staff',
                default   => '—',
            },
            $row->work_date?->format('d/m/Y') ?? '—',
            $row->check_in_at?->format('H:i') ?? '—',
            $row->check_out_at?->format('H:i') ?? '—',
            $row->work_hours ? $row->work_hours . ' giờ' : '—',
            $row->check_in_address ?? '—',
            $row->check_out_address ?? '—',
            $status,
        ];
    }

    public function title(): string
    {
        return 'Chấm Công';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1a1a2e'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PayrollExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private int $month,
        private int $year
    ) {}

    public function title(): string
    {
        return "Tháng {$this->month}-{$this->year}";
    }

    public function collection()
    {
        return Payroll::with('user')
            ->where('month', $this->month)
            ->where('year',  $this->year)
            ->orderBy('user_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'STT',
            'Họ và tên',
            'Tên đăng nhập',
            'Lương cứng (đ)',
            'Ngày công',
            'Giờ tăng ca',
            'Phụ cấp tăng ca (đ)',
            'Hoa hồng (đ)',
            'Thưởng KPI (đ)',
            '% KPI đạt',
            'Tổng lương (đ)',
            'Trạng thái',
        ];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;

        $validDays   = $row->valid_days   ?? 0;
        $workingDays = $row->working_days ?? 30;

        return [
            $i,
            $row->user->name       ?? '',
            $row->user->username   ?? '',
            $row->base_salary,
            "{$validDays}/{$workingDays} ngày",
            ($row->overtime_hours  ?? 0) . ' giờ',
            $row->overtime_allowance ?? 0,
            $row->total_commission,
            $row->kpi_bonus,
            $row->kpi_percent . '%',
            $row->total_salary,
            $row->status_label,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $lastRow = Payroll::where('month', $this->month)->where('year', $this->year)->count() + 2;
        $lastCol = 'L';

        // Header row style
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1a1a1a']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        // Number format cho cột tiền: D=lương cứng, G=tăng ca, H=hoa hồng, I=KPI, K=tổng
        foreach (['D', 'G', 'H', 'I', 'K'] as $col) {
            $sheet->getStyle("{$col}2:{$col}{$lastRow}")
                ->getNumberFormat()->setFormatCode('#,##0');
        }

        // Căn giữa: STT, Ngày công, Giờ tăng ca, % KPI, Trạng thái
        foreach (['A', 'E', 'F', 'J', 'L'] as $col) {
            $sheet->getStyle("{$col}2:{$col}{$lastRow}")
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Tổng lương bold
        $sheet->getStyle("K2:K{$lastRow}")->getFont()->setBold(true);

        // Tô màu vàng nhạt cho cột ngày công + tăng ca để nổi bật
        $sheet->getStyle("E1:G1")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '374151']],
        ]);

        // Border toàn bảng
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        // Freeze header row
        $sheet->freezePane('A2');

        // Row height header
        $sheet->getRowDimension(1)->setRowHeight(30);

        return [];
    }
}
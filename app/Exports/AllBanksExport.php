<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AllBanksExport implements FromView, WithStyles, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('payroll.con_epayment.exportAllBanksExcel', $this->data);
    }

    /** ===========================
     *  HEADER STYLING
     * =========================== */
    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFCCE5FF'] // Light blue header
                ]
            ]
        ];
    }

    /** ===========================
     *  AFTER SHEET FORMATTING
     * =========================== */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                /* =====================================
                   COLUMN SIZING
                ===================================== */
                $sheet->getColumnDimension('A')->setWidth(8);  // S/N
                $sheet->getColumnDimension('B')->setWidth(32); // Beneficiary
                $sheet->getColumnDimension('C')->setWidth(23); // Bank
                $sheet->getColumnDimension('D')->setWidth(10); // Branch
                $sheet->getColumnDimension('E')->setWidth(22); // Account No
                $sheet->getColumnDimension('F')->setWidth(18); // Amount
                $sheet->getColumnDimension('G')->setWidth(38); // Purpose

                /* =====================================
                   MAKE AMOUNT COLUMN BOLD
                ===================================== */
                $sheet->getStyle("F2:F{$highestRow}")->getFont()->setBold(true);

                /* =====================================
                   LOOP THROUGH ALL ROWS TO STYLE THEM
                ===================================== */
                for ($row = 2; $row <= $highestRow; $row++) {

                    $purpose = $sheet->getCell("G{$row}")->getValue();



                    // Deduction Row (Payroll Deduction)
                    $beneficiary = strtoupper($sheet->getCell("B{$row}")->getValue());

                    if (
                        str_contains($purpose, "PAYROLL DEDUCTION") ||
                        in_array($beneficiary, ['NASARAWA STATE TAX', 'NIGER STATE TAX', 'UNION DUES'])
                    ) {
                        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => 'FFC2185B']
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFCE4EC']
                            ]
                        ]);
                    }


                    // Staff Salary Row
                    if (str_contains($purpose, "Staff Salary")) {
                        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFE3F2FD'] // Light blue
                            ]
                        ]);
                    }

                    // Justice Salary Row
                    if (str_contains($purpose, "Justice Allowance")) {
                        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => 'FF1A237E'] // Deep blue text
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFBBDEFB'] // Light blue highlight
                            ],
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => ['argb' => 'FF0D47A1']
                                ]
                            ]
                        ]);
                    }

                    // Sub Total Row
                    // if (str_contains($purpose, "Sub Total")) {
                    //     $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                    //         'font' => ['bold' => true],
                    //         'fill' => [
                    //             'fillType' => Fill::FILL_SOLID,
                    //             'startColor' => ['argb' => 'FFFFF9C4'] // Light Yellow
                    //         ]
                    //     ]);
                    // }

                    // Sub Total Row
                    if (str_contains($purpose, "Sub Total")) {
                        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'size' => 20, // Bigger font
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFFF59D'] // Stronger Yellow
                            ],
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => ['argb' => 'FF000000']
                                ]
                            ]
                        ]);
                    }

                    // Grand Total Row
                    // if ($purpose === "Total") {
                    //     $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                    //         'font' => ['bold' => true],
                    //         'fill' => [
                    //             'fillType' => Fill::FILL_SOLID,
                    //             'startColor' => ['argb' => 'FFC8E6C9'] // Light green
                    //         ]
                    //     ]);
                    // }

                    // Grand Total Row
                    if ($purpose === "Total") {
                        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'size' => 22, // Even bigger font
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFA5D6A7'] // Darker Green
                            ],
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => ['argb' => 'FF000000']
                                ]
                            ]
                        ]);
                    }
                }

                /* =====================================
                   ADD BORDER TO WHOLE TABLE
                ===================================== */
                $sheet->getStyle("A1:G{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000']
                        ]
                    ]
                ]);
            }
        ];
    }
}

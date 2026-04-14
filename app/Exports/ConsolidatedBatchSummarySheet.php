<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class ConsolidatedBatchSummarySheet implements
    FromCollection,
    WithTitle,
    WithEvents,
    WithHeadings
{
    protected $ids;
    protected $grandTotal = 0;
    protected $totalPeople = 0;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function title(): string
    {
        return 'Mandate Summary';
    }

    public function headings(): array
    {
        return ['S/N', 'Batch No', 'Beneficiary', 'Total Amount (₦)'];
    }

    public function collection()
    {
        $rows = collect();
        $sn = 1;

        // Get all batches from the IDs (transactionIDs) you have
        $batches = DB::table('tblepayment')
            ->whereIn('batch', $this->ids)
            ->select('batch')
            ->distinct()
            ->get()
            ->pluck('batch');

        foreach ($batches as $batchNo) {

            $records = DB::table('tblepayment')
                ->where('batch', $batchNo)
                ->get();

            $count = $records->count();

            if ($count == 0) continue;

            // First beneficiary
            $firstBeneficiary = $records->first()->contractor ?? 'N/A';

            // Prepare "Name and X others"
            $othersCount = $count - 1;
            $beneficiaryDisplay = $firstBeneficiary;
            if ($othersCount > 0) {
                $beneficiaryDisplay .= " and {$othersCount} other" . ($othersCount > 1 ? 's' : '');
            }

            // Sum amount
            $sum = $records->sum(function ($row) {
                return $row->amount + $row->VATValue + $row->WHTValue + $row->stampduty;
            });

            $this->grandTotal += $sum;
            $this->totalPeople += $count;

            $rows->push([
                $sn++,
                $batchNo,
                $beneficiaryDisplay,
                $sum
            ]);
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '6AA84F']
                    ]
                ]);

                $highestRow = $sheet->getHighestRow();

                // Currency format
                $sheet->getStyle("D2:D{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                // Grand total row
                $totalRow = $highestRow + 1;

                $sheet->setCellValue("B{$totalRow}", 'GRAND TOTAL');
                $sheet->setCellValue("C{$totalRow}", $this->totalPeople);
                $sheet->setCellValue("D{$totalRow}", $this->grandTotal);
                $sheet->getStyle("B{$totalRow}:D{$totalRow}")->getFont()->setBold(true);
            }
        ];
    }
}

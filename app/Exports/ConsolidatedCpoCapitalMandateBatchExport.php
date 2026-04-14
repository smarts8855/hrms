<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ConsolidatedCpoCapitalMandateBatchExport implements WithMultipleSheets
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function sheets(): array
    {
        return [
            new ConsolidatedCapitalMandateSheet($this->ids), // Your existing consolidated layout
            //summary sheet by bank
            new ConsolidatedCapitalByBankMandateSheet($this->ids), // The new summary sheet
            new ConsolidatedCapitalBatchSummarySheet($this->ids) // The new summary sheet
        ];
    }
}
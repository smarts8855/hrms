<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ConsolidatedCpoMandateBatchExport implements WithMultipleSheets
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function sheets(): array
    {
        return [
            new ConsolidatedMandateSheet($this->ids), // Your existing consolidated layout
            new ConsolidatedBatchSummarySheet($this->ids) // The new summary sheet
        ];
    }
}
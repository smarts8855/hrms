<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ConsolidatedCpoCapitalRegeneratedMandateBatchExport implements WithMultipleSheets
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = is_array($ids) ? $ids : [$ids];
    }

    public function sheets(): array
    {
        return [
            new ConsolidatedCapitalRegeneratedMandateSheet($this->ids),
            new ConsolidatedCapitalByBankRegeneratedMandateSheet($this->ids), // The new summary sheet
        ];
    }
}
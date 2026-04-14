<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SingleCpoMandateBatchExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $batchNo;

    public function __construct($batchNo)
    {
        $this->batchNo = $batchNo;
    }

    public function collection()
    {
        return DB::table('tblepayment')
            ->select(
                'contractor',
                'accountName',
                'bank',
                'bank_branch',
                'accountNo',
                DB::raw('(amount + VATValue + WHTValue) as totalAmount'),
                'purpose'
            )
            ->where('batch', $this->batchNo)
            ->orderBy('transactionID')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Beneficiary',
            'Account Name',
            'Bank',
            'Branch',
            'Account Number',
            'Amount (₦)',
            'Purpose of Payment'
        ];
    }
}

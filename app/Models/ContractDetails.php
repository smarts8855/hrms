<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;


class ContractDetails extends model
{
    protected $table = 'tblcontractDetails';

    protected $fillable =
        [
            'fileNo',
            'procurement_contractID',
            'contract_Type',
            'ContractDescriptions',
            'economicVoult',
            'contractValue',
            'companyID',
            'beneficiary',
            'dateAward',
            'approvedBy',
            'approvalStatus',
            'approvalDate',
            'createdby',
            'datecreated',
            'openclose',
            'paymentStatus',
            'file_ex',
            'awaitingActionby',
            'voucherType',
    ];

    protected $hidden = [

    ];
    public $timestamps = false;
}

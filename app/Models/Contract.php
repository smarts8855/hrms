<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Contract extends model
{
    protected $table = 'create_contract';

    protected $fillable =
        [
            'fileNo',
            'contractorID',
            'amount',
            'liability_amount',
            'award_date',
            'description',
            'account_type',
            'economic_code',
            'token',
            'awaitingActionBy',
            'pushFrom',
            'active'
    ];

    protected $hidden = [
        //'remember_token',
    ];
    //public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Contractor extends model
{
    protected $table = 'tblcontractor';

    protected $fillable =
        [
            'contractor',
            'address',
            'phoneNo',
            'emailAddress',
            'Banker',
            'AccountNo',
            'sortCode',
            'TIN',
            'status',
            'token'
    ];

    protected $hidden = [

    ];
    public $timestamps = false;
}

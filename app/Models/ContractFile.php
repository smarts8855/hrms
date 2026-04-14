<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;


class ContractFile extends model
{
    protected $table = 'contract_file';

    protected $fillable =
        [
            'contractID',
            'userID',
            'fileNo',
            'file_name',
            'file_extension',
            'caption',
            'created_at'
    ];
    protected $hidden = [

    ];
    public $timestamps = false;
}

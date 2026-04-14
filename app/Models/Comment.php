<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Comment extends model
{
    protected $table = 'contract_comment';

    protected $fillable =
        [
            'comment',
            'contractID',
            'fileNoID',
            'userID',
            'date',
    ];

    protected $hidden = [

    ];
    public $timestamps = false;
}

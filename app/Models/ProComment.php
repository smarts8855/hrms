<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProComment extends Model
{
    protected $table = 'tblcontract_comment';
    protected $primaryKey = 'contract_commentID';
    use HasFactory;
}

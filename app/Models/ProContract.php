<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProContract extends Model
{
	protected $table = 'tblcontract_details';
	protected $primaryKey = 'contract_detailsID';
    use HasFactory;
}
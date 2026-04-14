<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procure extends Model
{
	protected $table = 'tblcontract_bidding';
	protected $primaryKey = 'contract_biddingID';
    use HasFactory;
}
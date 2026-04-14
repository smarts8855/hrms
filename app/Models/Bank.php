<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
	protected $table = 'tblbanklist';
	protected $primaryKey = 'bankID';
	 public $timestamps = false;
    use HasFactory;
}

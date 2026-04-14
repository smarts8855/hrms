<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentDocs extends Model
{
    protected $table = 'tblcomment_docs';
    protected $primaryKey = 'comment_docsID';
    public $timestamps = false;
    use HasFactory;
}

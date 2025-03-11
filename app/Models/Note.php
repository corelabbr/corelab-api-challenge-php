<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notes';
        
    /** 
     * Campos que aceitam dados em massa
    */
    protected $fillable = ['title', 'content', 'category', 'id_user','favorite', 'color'];
}

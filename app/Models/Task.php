<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Define quais colunas são "mass assignable"
    protected $fillable = [
        'title',
        'description',
        'is_favorite',
        'color'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TasksFactory> */
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = ['titulo', 'descricao', 'status','categoria_id', 'user_id'];
    public function categoria()
    {
        return $this->belongTo('categoria');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static all()
 * @method static find($id)
 * @method static findOrFail($id)
 */
class Task extends Model
{
    use HasFactory, HasUuids, SoftDeletes;


    protected $table = 'tasks';
    protected $fillable = [
        'title',
        'description',
        'background_color',
        'is_favorite'
    ];
    protected $hidden = [
        'deleted_at'
    ];
    protected $casts = [
        'is_favorite' => 'boolean',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];
}

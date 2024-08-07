<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mime_type',
        'original_name',
        'size',
    ];

    /**
     * Get the owning fileable model.
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * Get the file's size in a human-readable format.
     */
    public function getSizeForHumansAttribute(): string
    {
        $bytes = $this->size;

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    function getPathAttribute()
    {
        return storage_path('app/files/' . $this->name);
    }
}

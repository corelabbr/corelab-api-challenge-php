<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Actions\StoreBase64File;
use Illuminate\Support\Facades\Storage;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'is_favorite',
        'color',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    /**
     * Get file that are assigned this note.
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function syncFileFromRequest($request)
    {
        if($request->has('file')) {
            // Remove the old file if it exists
            $this->removeFile();

            $file = $request->input('file');

            if($file != null) {
                (new StoreBase64File($file, $this))->handle();
            }
        }
    }

    public function removeFile()
    {
        if($this->file) {
            Storage::disk('public')->delete('files/' . $this->file->name);
            $this->file->delete();
        }
    }
}

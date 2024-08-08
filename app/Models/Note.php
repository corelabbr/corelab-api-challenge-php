<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Actions\UploadFile;

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
    ];

    /**
     * Get file that are assigned this note.
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function addFileFromRequest($request)
    {
        $file = $request->file('file');

        if($file) {
            (new UploadFile($file, $this))->handle();
        }
    }
}

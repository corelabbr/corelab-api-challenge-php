<?php

namespace App\Actions;

use App\Models\File;

class UploadFile extends Action
{
    public function __construct(
        protected $file,
        protected $fileable
    ) {}

    public function handle()
    {
        $name = md5($this->file->getClientOriginalName() . time()) . '.' . $this->file->getClientOriginalExtension();

        $this->file->storeAs('/public/files', $name);

        return File::create([
            'name'           => $name,
            'mime_type'     => $this->file->getClientMimeType(),
            'original_name' => $this->file->getClientOriginalName(),
            'size'          => $this->file->getSize(),
            'fileable_id'   => $this->fileable->id,
            'fileable_type' => get_class($this->fileable),
        ]);
    }
}

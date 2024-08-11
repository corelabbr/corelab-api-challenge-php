<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;
use App\Models\File;

class StoreBase64File extends Action
{
    public function __construct(
        protected $base64File,
        protected $fileable
    ) {}

    public function handle()
    {
        // Decode the base64 file
        $fileContent = $this->processBase64File($this->base64File);

        // Generate a unique file name
        $fileName = md5(time()) . '.' . explode('/', $this->getMimeType())[1];

        // Store the file
        $this->storeFile($fileContent, $fileName);

        // Create record in the database
        return $this->createFileRecord($fileName, $this->getMimeType(), strlen($fileContent));
    }

    private function processBase64File($base64File)
    {
        $parts = explode(';', $base64File);
        $data = explode(',', $parts[1])[1];

        return base64_decode($data);
    }

    private function storeFile($fileContent, $fileName)
    {
        Storage::disk('public')->put('files/' . $fileName, $fileContent);
    }

    private function createFileRecord($fileName, $mimeType, $size)
    {
        return File::create([
            'name'           => $fileName,
            'mime_type'      => $mimeType,
            'size'           => $size,
            'fileable_id'    => $this->fileable->id,
            'fileable_type'  => get_class($this->fileable),
        ]);
    }

    private function getMimeType()
    {
        return explode(';', explode(':', $this->base64File)[1])[0];
    }
}

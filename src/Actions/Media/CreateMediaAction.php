<?php

namespace MediaManager\Actions\Media;

use Illuminate\Support\Facades\Storage;
use MediaManager\Entities\File;
use MediaManager\Helpers\FileHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateMediaAction
{

    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;

    }

    public function call(UploadedFile $file, array $data = [])
    {
        $file_name = FileHelper::slug($file->getClientOriginalName());
        $file_exists = $this->file->where('name', $file_name)->exists();

        if ($file_exists) {
            dd('exists');
        }




        // check if it has folder nad then get path
        $folder = null;
        if (array_key_exists('folder_id', $data)) {
            $folder = $this->file->findOrFail($data['folder_id']);
            $directory = $folder->name;
            $path = $directory . '/' . $file_name;
        } else {
            $path = $file_name;
        }
        // create file
        $data = [
            'name' => $file_name,
            'path' => config('media_manager.path') . '/' .$path,
            'extension' => substr(strrchr($file_name, '.'), 1),
            'mimetype' => $file->getClientMimeType(),
            'filesize' => $file->getFileInfo()->getSize(),
            'folder_id' => optional($folder)->id,
            'is_folder' => 0,
        ];

        $fileModel = $this->file->create($data);

        // move file
        try {
            $stream = fopen($file->getRealPath(), 'r+');
            $result = Storage::disk('public')->writeStream($path, $stream, [
                'mimetype' => $fileModel->mimetype,
            ]);

            dd($result);

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }


        dd($fileModel);


    }


}

<?php

namespace MediaManager\Helpers;

use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use MediaManager\Entities\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileHelper
{

    public static function slug(string $name)
    {
        $extension = self::getExtension($name);
        $name = str_replace($extension, '', $name);

        $name = Str::slug($name);

        return $name . strtolower($extension);
    }


    private static function getExtension(string $name)
    {
        return substr($name, strrpos($name, '.'));
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param File $fileModel
     * @return bool
     * @throws FileExistsException
     */
    public static function writeOnDisk(UploadedFile $uploadedFile, File $fileModel)
    {
        $stream = fopen($uploadedFile->getRealPath(), 'r+');
        $result = Storage::disk(config('media_manager.disk'))->writeStream($fileModel->path, $stream, [
            'mimetype' => $fileModel->mimetype,
            'visibility' => $options['visibility'] ?? 'public'
        ]);

        return $result;
    }


}

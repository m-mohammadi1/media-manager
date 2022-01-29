<?php

namespace MediaManager\Actions\Media;

use Exception;
use MediaManager\Entities\File;
use MediaManager\Exceptions\GeneralException;
use MediaManager\Helpers\FileHelper;
use MediaManager\Helpers\FolderHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateMediaAction
{

    private File $file;

    public function __construct(File $file, FileHelper $fileHelper)
    {
        $this->file = $file;

    }

    /**
     * @param UploadedFile $file
     * @param array $data
     * @return void
     * @throws GeneralException
     */
    public function call(UploadedFile $file, array $data = [], array $options = [])
    {
        $fileName = FileHelper::slug($file->getClientOriginalName());
        $fullPath = $this->getFileFullPath($data, $fileName);

        $this->checkActionCanBeDone($fileName, $fullPath);

        // move file
        try {
            // create file
            $fileModel = $this->createFile($file, $fileName, $fullPath, $data['folder_id'] ?? null);

            FileHelper::writeOnDisk($file, $fileModel);
        } catch (Exception $exception) {
            throw new GeneralException($exception->getMessage(), $exception->getCode());
        }


        return $fileModel;
    }

    /**
     * @param array $data
     * @param string $file_name
     * @return string
     */
    private function getFileFullPath(array $data, string $file_name): string
    {
        // check if it has folder nad then get path
        if (!array_key_exists('folder_id', $data)) {
            return config('media_manager.path') . $file_name;
        }

        $folder = $this->file->findOrFail($data['folder_id']);
        $directory = FolderHelper::getFolderParentsPath($folder);

        return config('media_manager.path') . $directory . '/' . $file_name;
    }

    /**
     * @param string $file_name
     * @param string $fullPath
     * @param UploadedFile $file
     * @param array $data
     * @return mixed
     */
    private function createFile(UploadedFile $file, string $fileName, string $fullPath, int $folderId = null)
    {
        $data = [
            'name' => $fileName,
            'path' => $fullPath,
            'extension' => substr(strrchr($fileName, '.'), 1),
            'mimetype' => $file->getClientMimeType(),
            'filesize' => $file->getFileInfo()->getSize(),
            'folder_id' => $folderId,
            'is_folder' => 0,
        ];
        return $this->file->create($data);
    }

    /**
     * @param string $file_name
     * @param string $fullPath
     * @return void
     * @throws GeneralException
     */
    private function checkActionCanBeDone(string $file_name, string $fullPath): void
    {
        if ($this->file->where('name', $file_name)->where('path', $fullPath)->exists()) {
            throw new GeneralException('file already exists');
        }
    }


}

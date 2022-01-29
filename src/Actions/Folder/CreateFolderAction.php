<?php

namespace MediaManager\Actions\Folder;

use Illuminate\Support\Facades\Storage;
use MediaManager\Entities\File;
use MediaManager\Exceptions\GeneralException;
use MediaManager\Helpers\FileHelper;
use MediaManager\Helpers\FolderHelper;

class CreateFolderAction
{

    /**
     * @var File|mixed
     */
    private $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function call(array $data, array $options = [])
    {
        $data['is_folder']  = true;
        $data['name'] = FolderHelper::slug($data['name']);

        $this->checkActionCanBeDone($data);


        $folder = $this->file->create($data);

        return $folder;
    }

    /**
     * @param array $data
     * @return void
     * @throws GeneralException
     */
    private function checkActionCanBeDone(array $data): void
    {
        if (!array_key_exists('parent_id', $data)) {
            return;
        }

        $parent_is_folder = $this->file->where('id', $data['parent_id'])->where('is_folder', true)->exists();
        if (!$parent_is_folder) {
            throw new GeneralException('parent prepared is not a folder');
        }
    }


}

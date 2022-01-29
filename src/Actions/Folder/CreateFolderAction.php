<?php

namespace MediaManager\Actions\Folder;

use MediaManager\Entities\File;

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

        return $this->file->create($data);
    }



}

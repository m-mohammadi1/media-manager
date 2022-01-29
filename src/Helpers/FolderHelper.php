<?php

namespace MediaManager\Helpers;

use Illuminate\Support\Str;
use MediaManager\Entities\File;

class FolderHelper
{

    public static function slug($name)
    {
        return Str::slug($name);
    }

    public static function getFolderParentsPath(File $folder)
    {
        $parent_names = self::getParentsNames($folder);

        return implode(DIRECTORY_SEPARATOR, $parent_names);
    }

    public static function getParentsNames(File $folder, array $names = [])
    {
        if (!$parent = $folder->parent_folder) {
            return $names;
        }

        $folderNames = array_merge([$parent->name], $names);
        return self::getParentsNames($parent, $folderNames);
    }

}

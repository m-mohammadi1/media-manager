<?php

namespace MediaManager\Helpers;

use Illuminate\Support\Str;

class FileHelper
{
    public static function slug($name)
    {
        $extension = self::getExtension($name);
        $name = str_replace($extension, '', $name);

        $name = Str::slug($name);

        return $name . strtolower($extension);
    }

    private static function getExtension($name)
    {
        return substr($name, strrpos($name, '.'));
    }

}

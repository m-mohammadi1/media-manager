<?php

namespace MediaManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *   properties
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $extension
 * @property string $mimetype
 * @property string $filesize
 * @property string $folder_id
 * @property string $is_folder
 *
 *   relations
 * @property BelongsTo $parent_folder
 */
class File extends Model
{
    protected $table = 'manager_files';

    protected $fillable = [
        'name',
        'path',
        'extension',
        'mimetype',
        'filesize',
        'folder_id',
        'is_folder',
    ];


    public function is_folder(): bool
    {
        return $this->is_folder;
    }


    public function parent_folder(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'folder_id');
    }


    public function getPath()
    {
        
    }
}

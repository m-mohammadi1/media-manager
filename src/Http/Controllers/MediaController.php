<?php

namespace MediaManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MediaManager\Actions\Folder\CreateFolderAction;
use MediaManager\Actions\Media\CreateMediaAction;
use MediaManager\Entities\File;

class MediaController extends Controller
{

    public function create()
    {

    }

    public function store(Request $request, CreateMediaAction $mediaAction)
    {
        $data = $request->validate([
            'file' => ['required', 'max:1000', 'mimes:jpg,png'] ,
            'folder_id' => ['sometimes', Rule::exists('manager_files', 'id')]
        ]);

        $folder = $mediaAction->call($data['file']);


        dd($folder);
    }


}

<?php

namespace MediaManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MediaManager\Actions\Folder\CreateFolderAction;
use MediaManager\Entities\File;

class FolderController extends Controller
{

    public function create()
    {

    }

    public function store(Request $request, CreateFolderAction $folderAction)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'] ,
            'parent_id' => ['sometimes', Rule::exists('manager_files', 'id')]
        ]);

        $folder = $folderAction->call($data);


        dd($folder);
    }


}

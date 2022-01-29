<?php

use \Illuminate\Support\Facades\Route;
use \MediaManager\Http\Controllers\FolderController;
use MediaManager\Http\Controllers\MediaController;


Route::resource('folder', FolderController::class);
Route::resource('media', MediaController::class);

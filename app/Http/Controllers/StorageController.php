<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFileRequest;
use App\Models\Storage\Storage;
use StorageService;

class StorageController extends Controller
{
    public function addFile(AddFileRequest $request)
    {
        $storage = Storage::find($request->get("storage_id"));
        foreach($request->file("files") as $file){
            $content = file_get_contents($file->getRealPath());
            $realName = StorageService::guessName($file);
            StorageService::addFileToStorage($storage, $request->get("path") . "/" . $realName,$content);
        }
    }
}

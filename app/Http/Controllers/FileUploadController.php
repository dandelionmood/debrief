<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class FileUploadController extends Controller
{
    public function create(Request $request)
    {
        $uploadedFile = $request->file('file');
        $path         = $uploadedFile->storePublicly('public/uploads');

        return response()->json([
            'extension' => $uploadedFile->guessExtension(),
            'fileName'  => $uploadedFile->getClientOriginalName(),
            'path'      => Storage::url($path),
        ]);
    }
}

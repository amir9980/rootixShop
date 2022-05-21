<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function product($fileName){
        $path = storage_path('app/images/products/' . $fileName);


//dd($path);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200, ['Content-Type' => $type]);

        return $response;
    }

    public function user($fileName){
        $path = storage_path('app/images/users/' . $fileName);


//dd($path);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200, ['Content-Type' => $type]);

        return $response;
    }
}

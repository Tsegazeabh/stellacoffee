<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Image;
use function PHPUnit\Framework\directoryExists;

class FileManagerController extends Controller
{
    //
    function __construct()
    {
    }

    protected function uploadImage(Request $request)
    {
        try {
            $root_path = '/lfm';
            $root_path_thumbnail = '/lfm/thumbnail';
            $image = $request->file('upload');
            $imagename = time() . '.' . $image->extension();
            $destinationPath = public_path($root_path_thumbnail);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imagename);
            $destinationPath = public_path($root_path);
            $image->move($destinationPath, $imagename);

            $images = array(
                "default" => url($root_path . '/' . $imagename),
                "800" => url($root_path . '/' . $imagename),
                "1024" => url($root_path . '/' . $imagename),
                "1920" => url($root_path . '/' . $imagename)
            );

            /*
             * array(
                "uploaded" => true,
                "url" => url($root_path . '/' . $imagename),
                "urls" =>
             */

            return response()->json($images);
        } catch (\Throwable $ex) {
            logError($ex);
            return response('unable to upload image', 503);
        }
    }
}

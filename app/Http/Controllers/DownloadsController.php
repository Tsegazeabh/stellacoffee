<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use mysql_xdevapi\Exception;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadsController extends Controller
{
    function __construct()
    {
    }
    /**
     * Downloads the file when download button is clicked.
     *
     * @return \Inertia\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getDownload(Request $request, $media_id) {
       try{
            $media = Media::Find($media_id);
           $headers =array($media->mime_type);
           return response()->download($media->getPath(), $media->file_name, $headers);
       }
       catch (\Throwable $ex)
       {
           logError($ex);
           if ($ex instanceof AuthorizationException) {
               abort(403, getUnAuthorizedAccessMessage());
           }
           return new JsonResponse(getGeneralAdminErrorMessage(), 503);
       }

    }
}

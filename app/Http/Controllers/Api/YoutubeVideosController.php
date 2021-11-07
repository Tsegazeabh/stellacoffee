<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EEUTVVideo;
use App\Models\YoutubeVideo;
use Google\Client;
use Google\Service\YouTube;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class YoutubeVideosController extends Controller
{
    function __construct()
    {
    }

    protected function getLatestYoutubeVideos()
    {
        $result = YoutubeVideo::orderBy('publishedAt', 'desc')->take(6)->get();
        return new JsonResponse($result);
    }

    protected function getLatestEEUTVYoutubeVideos(Request $request)
    {
        $result = EEUTVVideo::orderBy('publishedAt', 'desc')->paginate(6);
        return new JsonResponse($result);
    }


    protected function getPlayer(Request $request, $videoId)
    {
        $data['video_id'] = $videoId;
        return Inertia::render('Public/Videos/Player', $data);
    }
}

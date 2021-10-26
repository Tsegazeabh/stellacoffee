<?php


use Illuminate\Support\Facades\Log;

function mapSrcSet($thumbnails)
{
    $srcset = array();
    array_walk($thumbnails, function ($v, $k) use (&$srcset) {
        array_push($srcset, $v->url . ' ' . $v->width . 'w');
    });
    return $srcset;
}

function getLatestYoutubeVideos()
{
    $API_key = env('EEU_TV_YOUTUBE_API_KEY');
    $channelID = env('YOUTUBE_CHANNEL_ID');
    $playlistId = env('EEU_TV_YOUTUBE_PLAYLIST_ID');
    $publishedAfter = gmdate('Y-m-d\TH:i:s\Z');

//    '&publishedAfter=' . $publishedAfter .
    $result = json_decode(
        file_get_contents(
            'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet' .
            '&channelId=' . $channelID .
            '&playlistId=' . $playlistId .
            '&key=' . $API_key .
            (!empty($pageToken) ? '&pageToken=' . $pageToken : '')
        )
    );


    foreach ($result as $item)
    {
        App\Models\YoutubeVideo::create([
            'videoId' => $item->id->videoId,
            'title' => $item->snippet->title,
            'thumbnails' => $item->snippet->thumbnails,
            'srcset' => mapSrcSet($item->snippet->thumbnails),
            'publishedAt' => $item->snippet->publishedAt,
            'videoUrl' => 'https://www.youtube.com/embed/' . $item->id->videoId
        ]);
    }
}

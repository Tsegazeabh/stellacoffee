<?php

namespace App\Console\Commands;

use App\Models\YoutubeVideo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RetrieveLatestYoutubeVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'latest_videos:retrieve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will retrieve the list of latest videos uploaded to EEU\'s youtube channel on the last 24 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->comment('Retrieving new youtube videos');
        $API_key = env('LATEST_YOUTUBE_DATA_API_KEY');
        $channelID = env('YOUTUBE_CHANNEL_ID');
        $maxResults = 100;
        $options = array(
            'order' => 'date',
            'part' => 'snippet',
            'channelId' => $channelID,
            'key' => $API_key,
            'maxResults' => $maxResults
        );

        $latest_retrieved_video = YoutubeVideo::orderBy('publishedAt', 'desc')->first();

        if (!empty($latest_retrieved_video)) {
            $publishedAfter = gmdate('Y-m-d\TH:i:s\Z', strtotime($latest_retrieved_video->publishedAt));
        } else {
            $date = \DateTime::createFromFormat('d M Y', '17 Jan 1900')->format('Y-m-d H:i');
            $publishedAfter = gmdate('Y-m-d\TH:i:s\Z', strtotime($date));
        }
        $options['publishedAfter'] = $publishedAfter;

        $result = Http::get('https://www.googleapis.com/youtube/v3/search', $options);

        $result = json_decode(json_encode($result['items']), false);
        foreach ($result as $item) {
            $itemObj = json_decode(json_encode($item), false);
            $thumbnails = json_decode(json_encode($itemObj->snippet->thumbnails), true);
            if (!empty($itemObj->id) && isset($itemObj->id->videoId)) {
                if (!YoutubeVideo::where('video_id', $itemObj->id->videoId)->exists()) {
                    YoutubeVideo::create([
                        'video_id' => $itemObj->id->videoId,
                        'title' => $itemObj->snippet->title,
                        'description' => $itemObj->snippet->description,
                        'srcset' => json_encode($this->_mapSrcSet($thumbnails)),
                        'publishedAt' => $itemObj->snippet->publishedAt,
                        'videoUrl' => 'https://www.youtube.com/embed/' . $itemObj->id->videoId
                    ]);
                }
            }
        }
        return 0;
    }

    private function _mapSrcSet($thumbnails)
    {
        $srcset = array();
        array_walk($thumbnails, function ($v, $k) use (&$srcset) {
            array_push($srcset, $v["url"] . ' ' . $v["width"] . 'w');
        });
        return $srcset;
    }
}

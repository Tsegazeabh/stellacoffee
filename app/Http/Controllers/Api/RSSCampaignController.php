<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Services\IRSSCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Feed\Feed;
use Spatie\Feed\Helpers\ResolveFeedItems;

class RSSCampaignController extends Controller
{
    protected $campaign;

    function __construct(IRSSCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    protected function subscribe(Request $request)
    {
        try {
            if ($this->campaign->subscribe($request->get('email'))) {
                return response('You have subscribed successfully. Please verify your subscription with the link sent to your email.', 200);
            } else {
                return response('', 503);
            }
        } catch (\Throwable $ex) {
            logError($ex);
            return response($ex->getMessage(), 503);
        }
    }

    /**
     * generate latest contents to be sent as feeds to RSS channel subscribers
     */
    protected function generateFeeds()
    {
        try
        {
            $latest_contents = Content::with('contentable')
                ->withTrashed()
                ->published()
                ->whereHasMorph('contentable', getContentTypesForRSSFeeds())
                ->ofLanguage(getSessionLanguageId())
                ->forRSSFeed()
                ->orderBy('published_at', 'DESC')
                ->get();
        } catch (\Throwable $ex) {
            logError($ex);
        }
    }
}

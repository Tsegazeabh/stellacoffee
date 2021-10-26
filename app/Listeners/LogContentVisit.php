<?php

namespace App\Listeners;

use App\Events\ContentVisited;
use App\Models\ContentHit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogContentVisit
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ContentVisited $event
     * @return void
     */
    public function handle(ContentVisited $event)
    {
        $session_id = session()->getId();
        if (!ContentHit::where('content_id', $event->content->id)->where('session_id', $session_id)->exists()) {
            ContentHit::create([
                'content_id' => $event->content->id,
                'session_id' => $session_id,
                'user_agent' => $event->request->server('HTTP_USER_AGENT'),
                'ip_address' => $event->request->ip()
            ]);
        }
    }
}

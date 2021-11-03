<?php

return [
    'key'=> env('MC_API_KEY', '713a59efd21e0592a0caab41d6c160a9-us5'),
    'dc'=> env('MC_DATA_CENTER', 'us5'),
    'api_version'=> env('MC_VERSION', '3.0'),
    'timeouts'=>env('MC_TIMEOUTS',120), //in seconds
    'audience_id'=>env('MC_AUDIENCE_ID','e0e31e05c3'),
];

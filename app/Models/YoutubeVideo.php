<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class YoutubeVideo extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    protected $appends=['src_sets'];

    protected $casts = [
        'srcset' => 'array'
    ];

    public function getSrcSetsAttribute(){
        return json_decode($this->srcset, true);
    }

}

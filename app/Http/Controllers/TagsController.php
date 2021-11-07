<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{

    function __construct()
    { }

    protected function getAllTags()
    {
        try {
            $tags = Tag::get();
            return response($tags);
        } catch (\Exception $ex) {
            report($ex);
            logError($ex);
            return response([]);
        }
    }

    protected function createTag(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            try {
                $tag = Arr::except($request->all(), 'csrf');
                $tag = Tag::firstOrCreate($tag);
                $tags = Tag::get();
                return response($tags, 200);
            } catch (\Exception $ex) {
                report($ex);
                logError($ex);
                return response([]);
            }
        });

        return $result;
    }
}

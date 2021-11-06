<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductPackageController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        try {
            Log::info("Here");
            return Inertia::render('Public/ProductPackage/ProductPackageIndex');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
    }
}

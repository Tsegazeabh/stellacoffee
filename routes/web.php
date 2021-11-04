<?php

use App\Http\Controllers\CMS\CertificationController;
use App\Http\Controllers\CMS\ContactUsRequestController;
use App\Http\Controllers\CMS\HistoryController;
use App\Http\Controllers\CMS\ProductBlendController;
use App\Http\Controllers\CMS\ProductPackageController;
use App\Http\Controllers\CMS\QualityControlProcessController;
use App\Http\Controllers\CMS\RoastingGuideController;
use App\Http\Controllers\CMS\RoastingMachineController;
use App\Http\Controllers\CMS\RoastingProcessController;
use App\Http\Controllers\CMS\RoastingServiceController;
use App\Http\Controllers\CMS\StellaCoffeeOriginController;
use App\Http\Controllers\CMS\SuccessStoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::feeds();

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('error')->group(function () {
    Route::get('/403', function () {
        return Inertia::render('Errors/403');
    })->name('error_403');
    Route::get('/404', function () {
        return Inertia::render('Errors/404');
    })->name('error_404');
    Route::get('query-exception', function () {
        return Inertia::render('Errors/QueryException');
    })->name('query_error');
    Route::get('unhandled', function () {
        return Inertia::render('Errors/UnhandledException');
    })->name('unhandled_error');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::prefix(getSecureURL('auth'))->group(function () {
    require __DIR__ . '/auth.php';
//    Route::prefix('roles')->middleware('auth')->group(function () {
//        Route::get('/', [RolesController::class, 'index'])->name('roles.index');
//    });
//});

require __DIR__ . '/cms.php';

Route::prefix('certification')->group(function () {
    Route::get('latest-certification', [CertificationController::class, 'getLatestCertification'])->name('latest-certification');
    Route::get('detail/{contentId}', [CertificationController::class, 'getDetail'])->name('certification-detail');
});
Route::prefix('history')->group(function () {
    Route::get('latest-history', [HistoryController::class, 'getLatestHistory'])->name('latest-history');
    Route::get('detail/{contentId}', [HistoryController::class, 'getDetail'])->name('history-detail');
});
Route::prefix('contact-us-request')->group(function () {
    Route::get('contact-us-request-creation-page', [ContactUsRequestController::class, 'createGet'])->name('contact-us-request-creation-page');
    Route::post('post-contact-us-request', [ContactUsRequestController::class, 'createPost'])->name('post-contact-us-request');
});
Route::prefix('product-blend')->group(function () {
    Route::get('latest-product-blend', [ProductBlendController::class, 'getLatestProductBlend'])->name('latest-product-blend');
    Route::get('detail/{contentId}', [ProductBlendController::class, 'getDetail'])->name('product-blend-detail');
});
Route::prefix('product-package')->group(function () {
    Route::get('latest-product-package', [ProductPackageController::class, 'getLatestProductPackage'])->name('latest-product-package');
    Route::get('detail/{contentId}', [ProductPackageController::class, 'getDetail'])->name('product-package-detail');
});
Route::prefix('quality-control-process')->group(function () {
    Route::get('latest-quality-control-process', [QualityControlProcessController::class, 'getLatestQualityControlProcess'])->name('latest-quality-control-process');
    Route::get('detail/{contentId}', [QualityControlProcessController::class, 'getDetail'])->name('quality-control-process-detail');
});
Route::prefix('roasting-guide')->group(function () {
    Route::get('latest-roasting-guide', [RoastingGuideController::class, 'getLatestRoastingGuide'])->name('latest-roasting-guide');
    Route::get('detail/{contentId}', [RoastingGuideController::class, 'getDetail'])->name('roasting-guide-detail');
});
Route::prefix('roasting-machine')->group(function () {
    Route::get('latest-roasting-machine', [RoastingMachineController::class, 'getLatestRoastingMachine'])->name('latest-roasting-machine');
    Route::get('detail/{contentId}', [RoastingMachineController::class, 'getDetail'])->name('roasting-machine-detail');
});
Route::prefix('roasting-process')->group(function () {
    Route::get('latest-roasting-process', [RoastingProcessController::class, 'getLatestRoastingProcess'])->name('latest-roasting-process');
    Route::get('detail/{contentId}', [RoastingProcessController::class, 'getDetail'])->name('roasting-process-detail');
});
Route::prefix('roasting-service')->group(function () {
    Route::get('latest-roasting-service', [RoastingServiceController::class, 'getLatestRoastingService'])->name('latest-roasting-service');
    Route::get('detail/{contentId}', [RoastingServiceController::class, 'getDetail'])->name('roasting-service-detail');
});
Route::prefix('stella-coffee-origin')->group(function () {
    Route::get('latest-stella-coffee-origin', [StellaCoffeeOriginController::class, 'getLatestStellaCoffeeOrigin'])->name('latest-stella-coffee-origin');
    Route::get('detail/{contentId}', [StellaCoffeeOriginController::class, 'getDetail'])->name('stella-coffee-origin-detail');
});
Route::prefix('success-story')->group(function () {
    Route::get('latest-success-story', [SuccessStoryController::class, 'getLatestSuccessStory'])->name('latest-success-story');
    Route::get('detail/{contentId}', [SuccessStoryController::class, 'getDetail'])->name('success-story-detail');
});


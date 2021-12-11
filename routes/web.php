<?php

use App\Http\Controllers\Api\YoutubeVideosController;
use App\Http\Controllers\Auth\RolesController;
use App\Http\Controllers\CMS\CertificationController;
use App\Http\Controllers\CMS\ContactUsRequestController;
use App\Http\Controllers\CMS\ContentsController;
use App\Http\Controllers\CMS\CountryController;
use App\Http\Controllers\CMS\CuppingEventController;
use App\Http\Controllers\CMS\CuppingProcedureController;
use App\Http\Controllers\CMS\CustomerTestimonialController;
use App\Http\Controllers\CMS\DutyFreeLocationController;
use App\Http\Controllers\CMS\ExportDestinationController;
use App\Http\Controllers\CMS\ExportProcessController;
use App\Http\Controllers\CMS\FactoryLocationController;
use App\Http\Controllers\CMS\HistoryController;
use App\Http\Controllers\CMS\MainSliderController;
use App\Http\Controllers\CMS\NewsController;
use App\Http\Controllers\CMS\PartnerController;
use App\Http\Controllers\CMS\ShopController;
use App\Http\Controllers\CMS\StoresController;
use App\Http\Controllers\CMS\PrivacyPolicyController;
use App\Http\Controllers\CMS\ProductBlendController;
use App\Http\Controllers\CMS\ProductPackageController;
use App\Http\Controllers\CMS\QualityControlProcessController;
use App\Http\Controllers\CMS\RoastingGuideController;
use App\Http\Controllers\CMS\RoastingMachineController;
use App\Http\Controllers\CMS\RoastingProcessController;
use App\Http\Controllers\CMS\RoastingServiceController;
use App\Http\Controllers\CMS\StellaCoffeeOriginController;
use App\Http\Controllers\CMS\SuccessStoryController;
use App\Http\Controllers\CMS\TermAndConditionController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SEOController;
use App\Http\Controllers\TagsController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [ContentsController::class, 'searchContents'])->name('search');
Route::get('/sitemap', [SEOController::class, 'generateSitemap'])->name('sitemap');

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

Route::prefix(getSecureURL('auth'))->group(function () {
    require __DIR__ . '/auth.php';
    Route::prefix('roles')->middleware('auth')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('roles.index');
    });
});

require __DIR__ . '/cms.php';

Route::prefix('tags')->group(function () {
    Route::get('/', [TagsController::class, 'getAllTags'])->name('fetch-tags');
    Route::post('/', [TagsController::class, 'createTag'])->name('create-tag');
});

Route::prefix('certification')->group(function () {
    Route::get('latest-certification', [CertificationController::class, 'getLatestCertification'])->name('latest-certification');
    Route::get('detail/{contentId}', [CertificationController::class, 'getDetail'])->name('certification-detail');
});
Route::prefix('history')->group(function () {
    Route::get('/', [HistoryController::class, 'getAllHistory'])->name('history-index');
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
Route::prefix('packages')->group(function () {
    Route::get('/', [ProductPackageController::class, 'index'])->name('product-packages');
    Route::get('latest-product-package', [ProductPackageController::class, 'getLatestProductPackage'])->name('latest-product-package');
    Route::get('detail/{contentId}', [ProductPackageController::class, 'getDetail'])->name('product-package-detail');
});
Route::prefix('quality-control-process')->group(function () {
    Route::get('latest-quality-control-process', [QualityControlProcessController::class, 'getLatestQualityControlProcess'])->name('latest-quality-control-process');
    Route::get('tab-quality-control-process', [QualityControlProcessController::class, 'getTabQualityControlProcess'])->name('tab-quality-control-process');
    Route::get('detail/{contentId}', [QualityControlProcessController::class, 'getDetail'])->name('quality-control-process-detail');
});
Route::prefix('roasting-guide')->group(function () {
    Route::get('latest-roasting-guide', [RoastingGuideController::class, 'getLatestRoastingGuide'])->name('latest-roasting-guide');
    Route::get('tab-roasting-guide', [RoastingGuideController::class, 'getTabRoastingGuide'])->name('tab-roasting-guide');
    Route::get('detail/{contentId}', [RoastingGuideController::class, 'getDetail'])->name('roasting-guide-detail');
});
Route::prefix('roasting-machine')->group(function () {
    Route::get('latest-roasting-machine', [RoastingMachineController::class, 'getLatestRoastingMachine'])->name('latest-roasting-machine');
    Route::get('tab-roasting-machine', [RoastingMachineController::class, 'getTabRoastingMachine'])->name('tab-roasting-machine');
    Route::get('detail/{contentId}', [RoastingMachineController::class, 'getDetail'])->name('roasting-machine-detail');
});
Route::prefix('roasting-process')->group(function () {
    Route::get('latest-roasting-process', [RoastingProcessController::class, 'getLatestRoastingProcess'])->name('latest-roasting-process');
    Route::get('tab-roasting-process', [RoastingProcessController::class, 'getTabRoastingProcess'])->name('tab-roasting-process');
    Route::get('detail/{contentId}', [RoastingProcessController::class, 'getDetail'])->name('roasting-process-detail');
});
Route::prefix('roasting-service')->group(function () {
    Route::get('latest-roasting-service', [RoastingServiceController::class, 'getLatestRoastingService'])->name('latest-roasting-service');
    Route::get('tab-roasting-service', [RoastingServiceController::class, 'getTabRoastingService'])->name('tab-roasting-service');
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
Route::prefix('contents')->group(function () {
    Route::get('{type}', [ContentsController::class, 'getContents'])->name('content-index-page');
    Route::get('most-popular-contents/{limit}', [ContentsController::class, 'getPopularContents'])->name('most-popular-contents');
    Route::post('{content_id}/related-contents', [ContentsController::class, 'getRelatedContents'])->name('related-contents');
});

Route::prefix('videos')->group(function () {
    Route::get('youtube', [YoutubeVideosController::class, 'getLatestYoutubeVideos'])->name('youtube-videos');
    Route::post('eeu-tv', [YoutubeVideosController::class, 'getLatestStellaTVYoutubeVideos'])->name('stella-tv-videos');
    Route::get('play/{videoId}', [YoutubeVideosController::class, 'getPlayer'])->name('video-player');
});

Route::prefix('file-manager')->group(function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('lfm-index');
    Route::post('/upload-image', [FileManagerController::class, 'uploadImage'])->name('lfm-upload-image');
});
Route::prefix('privacy-policy')->group(function () {
    Route::get('privacy-policy-index', [PrivacyPolicyController::class, 'getLatestPrivacyPolicy'])->name('privacy-policy-latest');
    Route::get('detail', [PrivacyPolicyController::class, 'getDetail'])->name('privacy-policy-detail');
});
Route::prefix('term-and-condition')->group(function () {
    //Route::get('term-and-condition-index', [TermAndConditionController::class, 'getLatestTermAndCondition'])->name('term-and-condition-index');
    Route::get('detail', [TermAndConditionController::class, 'getDetail'])->name('term-and-condition-detail');
});
Route::prefix('country')->group(function () {
    Route::post('get-countries', [CountryController::class, 'getCountries'])->name('get-countries');
    Route::get('get-all-countries', [CountryController::class, 'getAllCountries'])->name('get-all-countries');
});

Route::prefix('export-process')->group(function () {
    Route::get('/', [ExportProcessController::class, 'index'])->name('export-processes');
    Route::get('detail/{id}', [ExportProcessController::class, 'getDetail'])->name('export-process-detail');
});

Route::prefix('export-destination')->group(function () {
    Route::get('/', [ExportDestinationController::class, 'index'])->name('export-destinations');
    Route::get('detail/{id}', [ExportDestinationController::class, 'getDetail'])->name('export-destination-detail');
});

Route::prefix('stores')->group(function () {
    Route::get('/', [StoresController::class, 'index'])->name('stores');
    Route::get('detail/{id}', [StoresController::class, 'getDetail'])->name('store-detail');
});

Route::prefix('duty-free-location')->group(function () {
    Route::get('/', [DutyFreeLocationController::class, 'index'])->name('duty-free-locations');
    Route::get('detail/{id}', [DutyFreeLocationController::class, 'getDetail'])->name('duty-free-location-detail');
});

Route::prefix('factory-location')->group(function () {
    Route::get('/', [FactoryLocationController::class, 'index'])->name('factory-locations');
    Route::get('detail/{id}', [FactoryLocationController::class, 'getDetail'])->name('factory-location-detail');
});

Route::prefix('shops')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('shops');
    Route::get('detail/{id}', [ShopController::class, 'getDetail'])->name('shop-detail');
});

Route::prefix('cupping-procedures')->group(function () {
    Route::get('/', [CuppingProcedureController::class, 'index'])->name('cupping-procedures');
    Route::get('detail/{id}', [CuppingProcedureController::class, 'getDetail'])->name('cupping-procedure-detail');
});

Route::prefix('cupping-events')->group(function () {
    Route::get('/', [CuppingEventController::class, 'index'])->name('cupping-events');
    Route::get('detail/{id}', [CuppingEventController::class, 'getDetail'])->name('cupping-event-detail');
});
Route::prefix('partner')->group(function () {
    Route::get('latest-partner', [PartnerController::class, 'getLatestPartner'])->name('latest-partner');
    Route::get('detail/{contentId}', [PartnerController::class, 'getDetail'])->name('partner-detail');
});
Route::prefix('main-slider')->group(function () {
    Route::get('latest-main-slider', [MainSliderController::class, 'getLatestMainSlider'])->name('latest-main-slider');
    Route::get('detail/{contentId}', [MainSliderController::class, 'getDetail'])->name('main-slider-detail');
});
Route::prefix('news')->group(function () {
    Route::get('latest-news', [NewsController::class, 'getLatestNews'])->name('latest-news');
    Route::get('detail/{contentId}', [NewsController::class, 'getDetail'])->name('news-detail');
});

Route::prefix('testimonials')->group(function () {
    Route::get('/', [CustomerTestimonialController::class, 'index'])->name('testimonials');
    Route::get('detail/{id}', [CustomerTestimonialController::class, 'getDetail'])->name('testimonial-detail');
});

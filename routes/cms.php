<?php

use App\Http\Controllers\CMS\CertificationController;
use App\Http\Controllers\CMS\ContactUsRequestController;
use App\Http\Controllers\CMS\ContentsController;
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
use Illuminate\Support\Facades\Route;

Route::prefix(getSecureURL('cms'))->middleware(['auth', 'verified', 'password.changed'])->group(function () {
    Route::prefix('certification')->group(function () {
        Route::get(getSecureURL(1), [CertificationController::class, 'createGet'])->name('certification-creation-page');
        Route::post(getSecureURL(2), [CertificationController::class, 'createPost'])->name('post-certification');
        Route::get(getSecureURL(4), [CertificationController::class, 'manageCertification'])->name('certification-management-page');
        Route::post('fetch-certification', [CertificationController::class, 'fetchCertification'])->name('fetch-certification');
        Route::post(getSecureURL(4), [CertificationController::class, 'manageCertification'])->name('search-certification');
        Route::get(getSecureURL(6).'/{id}', [CertificationController::class, 'editGet'])->name('certification-editor-page');
        Route::put(getSecureURL(7).'/{id}', [CertificationController::class, 'editPost'])->name('edit-certification');
        Route::get('preview/{id}', [CertificationController::class, 'preview'])->name('preview-certification');
    });

    Route::prefix('history')->group(function () {
        Route::get(getSecureURL(1), [HistoryController::class, 'createGet'])->name('history-creation-page');
        Route::post(getSecureURL(2), [HistoryController::class, 'createPost'])->name('post-history');
        Route::get('manage', [HistoryController::class, 'manageHistory'])->name('history-management-page');
        Route::post('fetch-history', [HistoryController::class, 'fetchHistory'])->name('fetch-history');
        Route::post(getSecureURL(4), [HistoryController::class, 'manageHistory'])->name('search-history');
        Route::get(getSecureURL(6).'/{id}', [HistoryController::class, 'editGet'])->name('history-editor-page');
        Route::put(getSecureURL(7).'/{id}', [HistoryController::class, 'editPost'])->name('edit-history');
        Route::get('preview/{id}', [HistoryController::class, 'preview'])->name('preview-history');
    });

    Route::prefix('contact-us-request')->group(function () {
        Route::get(getSecureURL(4), [ContactUsRequestController::class, 'manageContactUsRequest'])->name('contact-us-request-management-page');
        Route::post(getSecureURL(4), [ContactUsRequestController::class, 'manageContactUsRequest'])->name('search-contact-us-request');
        Route::get(getSecureURL(6).'/{id}', [ContactUsRequestController::class, 'editGet'])->name('contact-us-request-editor-page');
        Route::post('fetch-contact-us-request', [ContactUsRequestController::class, 'fetchContactUsRequest'])->name('fetch-contact-us-request');
        Route::put(getSecureURL(7).'/{id}', [ContactUsRequestController::class, 'editPost'])->name('edit-contact-us-request');
        Route::put(getSecureURL('close').'/{id}', [ContactUsRequestController::class, 'closeUpdate'])->name('close-request');
        Route::put(getSecureURL('open').'/{id}', [ContactUsRequestController::class, 'openUpdate'])->name('open-request');
        Route::get(getSecureURL(3).'/{id}', [ContactUsRequestController::class, 'detailGet'])->name('contact-us-request-detail');
        Route::put(getSecureURL(11).'/{id}', [ContactUsRequestController::class, 'archive'])->name('archive-request');
        Route::delete(getSecureURL(8).'/{id}', [ContactUsRequestController::class, 'delete'])->name('delete-request');
    });
    Route::prefix('product-blend')->group(function () {
        Route::get(getSecureURL(1), [ProductBlendController::class, 'createGet'])->name('product-blend-creation-page');
        Route::post(getSecureURL(2), [ProductBlendController::class, 'createPost'])->name('post-product-blend');
        Route::get(getSecureURL(4), [ProductBlendController::class, 'manageProductBlend'])->name('product-blend-management-page');
        Route::post('fetch-product-blend', [ProductBlendController::class, 'fetchProductBlend'])->name('fetch-product-blend');
        Route::post(getSecureURL(4), [ProductBlendController::class, 'manageProductBlend'])->name('search-product-blend');
        Route::get(getSecureURL(6).'/{id}', [ProductBlendController::class, 'editGet'])->name('product-blend-editor-page');
        Route::put(getSecureURL(7).'/{id}', [ProductBlendController::class, 'editPost'])->name('edit-product-blend');
        Route::get('preview/{id}', [ProductBlendController::class, 'preview'])->name('preview-product-blend');
    });
    Route::prefix('product-package')->group(function () {
        Route::get(getSecureURL(1), [ProductPackageController::class, 'createGet'])->name('product-package-creation-page');
        Route::post(getSecureURL(2), [ProductPackageController::class, 'createPost'])->name('post-product-package');
        Route::get(getSecureURL(4), [ProductPackageController::class, 'manageProductPackage'])->name('product-package-management-page');
        Route::post('fetch-product-package', [ProductPackageController::class, 'fetchProductPackage'])->name('fetch-product-package');
        Route::post(getSecureURL(4), [ProductPackageController::class, 'manageProductPackage'])->name('search-product-package');
        Route::get(getSecureURL(6).'/{id}', [ProductPackageController::class, 'editGet'])->name('product-package-editor-page');
        Route::put(getSecureURL(7).'/{id}', [ProductPackageController::class, 'editPost'])->name('edit-product-package');
        Route::get('preview/{id}', [ProductPackageController::class, 'preview'])->name('preview-product-package');
    });
    Route::prefix('quality-control-process')->group(function () {
        Route::get(getSecureURL(1), [QualityControlProcessController::class, 'createGet'])->name('quality-control-process-creation-page');
        Route::post(getSecureURL(2), [QualityControlProcessController::class, 'createPost'])->name('post-quality-control-process');
        Route::get(getSecureURL(4), [QualityControlProcessController::class, 'manageQualityControlProcess'])->name('quality-control-process-management-page');
        Route::post('fetch-quality-control-process', [QualityControlProcessController::class, 'fetchQualityControlProcess'])->name('fetch-quality-control-process');
        Route::post(getSecureURL(4), [QualityControlProcessController::class, 'manageQualityControlProcess'])->name('search-quality-control-process');
        Route::get(getSecureURL(6).'/{id}', [QualityControlProcessController::class, 'editGet'])->name('quality-control-process-editor-page');
        Route::put(getSecureURL(7).'/{id}', [QualityControlProcessController::class, 'editPost'])->name('edit-quality-control-process');
        Route::get('preview/{id}', [QualityControlProcessController::class, 'preview'])->name('preview-quality-control-process');
    });
    Route::prefix('roasting-guide')->group(function () {
        Route::get(getSecureURL(1), [RoastingGuideController::class, 'createGet'])->name('roasting-guide-creation-page');
        Route::post(getSecureURL(2), [RoastingGuideController::class, 'createPost'])->name('post-roasting-guide');
        Route::get(getSecureURL(4), [RoastingGuideController::class, 'manageRoastingGuide'])->name('roasting-guide-management-page');
        Route::post('fetch-roasting-guide', [RoastingGuideController::class, 'fetchRoastingGuide'])->name('fetch-roasting-guide');
        Route::post(getSecureURL(4), [RoastingGuideController::class, 'manageRoastingGuide'])->name('search-roasting-guide');
        Route::get(getSecureURL(6).'/{id}', [RoastingGuideController::class, 'editGet'])->name('roasting-guide-editor-page');
        Route::put(getSecureURL(7).'/{id}', [RoastingGuideController::class, 'editPost'])->name('edit-roasting-guide');
        Route::get('preview/{id}', [RoastingGuideController::class, 'preview'])->name('preview-roasting-guide');
    });
    Route::prefix('roasting-machine')->group(function () {
        Route::get(getSecureURL(1), [RoastingMachineController::class, 'createGet'])->name('roasting-machine-creation-page');
        Route::post(getSecureURL(2), [RoastingMachineController::class, 'createPost'])->name('post-roasting-machine');
        Route::get(getSecureURL(4), [RoastingMachineController::class, 'manageRoastingMachine'])->name('roasting-machine-management-page');
        Route::post('fetch-roasting-machine', [RoastingMachineController::class, 'fetchRoastingMachine'])->name('fetch-roasting-machine');
        Route::post(getSecureURL(4), [RoastingMachineController::class, 'manageRoastingMachine'])->name('search-roasting-machine');
        Route::get(getSecureURL(6).'/{id}', [RoastingMachineController::class, 'editGet'])->name('roasting-machine-editor-page');
        Route::put(getSecureURL(7).'/{id}', [RoastingMachineController::class, 'editPost'])->name('edit-roasting-machine');
        Route::get('preview/{id}', [RoastingMachineController::class, 'preview'])->name('preview-roasting-machine');
    });
    Route::prefix('roasting-process')->group(function () {
        Route::get(getSecureURL(1), [RoastingProcessController::class, 'createGet'])->name('roasting-process-creation-page');
        Route::post(getSecureURL(2), [RoastingProcessController::class, 'createPost'])->name('post-roasting-process');
        Route::get(getSecureURL(4), [RoastingProcessController::class, 'manageRoastingProcess'])->name('roasting-process-management-page');
        Route::post('fetch-roasting-process', [RoastingProcessController::class, 'fetchRoastingProcess'])->name('fetch-roasting-process');
        Route::post(getSecureURL(4), [RoastingProcessController::class, 'manageRoastingProcess'])->name('search-roasting-process');
        Route::get(getSecureURL(6).'/{id}', [RoastingProcessController::class, 'editGet'])->name('roasting-process-editor-page');
        Route::put(getSecureURL(7).'/{id}', [RoastingProcessController::class, 'editPost'])->name('edit-roasting-process');
        Route::get('preview/{id}', [RoastingProcessController::class, 'preview'])->name('preview-roasting-process');
    });
    Route::prefix('roasting-service')->group(function () {
        Route::get(getSecureURL(1), [RoastingServiceController::class, 'createGet'])->name('roasting-service-creation-page');
        Route::post(getSecureURL(2), [RoastingServiceController::class, 'createPost'])->name('post-roasting-service');
        Route::get(getSecureURL(4), [RoastingServiceController::class, 'manageRoastingService'])->name('roasting-service-management-page');
        Route::post('fetch-roasting-service', [RoastingServiceController::class, 'fetchRoastingService'])->name('fetch-roasting-service');
        Route::post(getSecureURL(4), [RoastingServiceController::class, 'manageRoastingService'])->name('search-roasting-service');
        Route::get(getSecureURL(6).'/{id}', [RoastingServiceController::class, 'editGet'])->name('roasting-service-editor-page');
        Route::put(getSecureURL(7).'/{id}', [RoastingServiceController::class, 'editPost'])->name('edit-roasting-service');
        Route::get('preview/{id}', [RoastingServiceController::class, 'preview'])->name('preview-roasting-service');
    });
    Route::prefix('stella-coffee-origin')->group(function () {
        Route::get(getSecureURL(1), [StellaCoffeeOriginController::class, 'createGet'])->name('stella-coffee-origin-creation-page');
        Route::post(getSecureURL(2), [StellaCoffeeOriginController::class, 'createPost'])->name('post-stella-coffee-origin');
        Route::get(getSecureURL(4), [StellaCoffeeOriginController::class, 'manageStellaCoffeeOrigin'])->name('stella-coffee-origin-management-page');
        Route::post('fetch-stella-coffee-origin', [StellaCoffeeOriginController::class, 'fetchStellaCoffeeOrigin'])->name('fetch-stella-coffee-origin');
        Route::post(getSecureURL(4), [StellaCoffeeOriginController::class, 'manageStellaCoffeeOrigin'])->name('search-stella-coffee-origin');
        Route::get(getSecureURL(6).'/{id}', [StellaCoffeeOriginController::class, 'editGet'])->name('stella-coffee-origin-editor-page');
        Route::put(getSecureURL(7).'/{id}', [StellaCoffeeOriginController::class, 'editPost'])->name('edit-stella-coffee-origin');
        Route::get('preview/{id}', [StellaCoffeeOriginController::class, 'preview'])->name('preview-stella-coffee-origin');
    });
    Route::prefix('success-story')->group(function () {
        Route::get(getSecureURL(1), [SuccessStoryController::class, 'createGet'])->name('success-story-creation-page');
        Route::post(getSecureURL(2), [SuccessStoryController::class, 'createPost'])->name('post-success-story');
        Route::get(getSecureURL(4), [SuccessStoryController::class, 'manageSuccessStory'])->name('success-story-management-page');
        Route::post('fetch-success-story', [SuccessStoryController::class, 'fetchSuccessStory'])->name('fetch-success-story');
        Route::post(getSecureURL(4), [SuccessStoryController::class, 'manageSuccessStory'])->name('search-success-story');
        Route::get(getSecureURL(6).'/{id}', [SuccessStoryController::class, 'editGet'])->name('success-story-editor-page');
        Route::put(getSecureURL(7).'/{id}', [SuccessStoryController::class, 'editPost'])->name('edit-success-story');
        Route::get('preview/{id}', [SuccessStoryController::class, 'preview'])->name('preview-success-story');
    });
//
//    Route::prefix('country')->group(function () {
//        Route::get(getSecureURL(1), [CountryController::class, 'createGet'])->name('country-creation-page');
//        Route::post(getSecureURL(2), [CountryController::class, 'createPost'])->name('post-country');
//        Route::get(getSecureURL(4), [CountryController::class, 'manageCountry'])->name('country-management-page');
//        Route::post('fetch-country', [CountryController::class, 'fetchCountry'])->name('fetch-country');
//        Route::post(getSecureURL(4), [CountryController::class, 'manageCountry'])->name('search-country');
//        Route::get(getSecureURL(6).'/{id}', [CountryController::class, 'editGet'])->name('country-editor-page');
//        Route::put(getSecureURL(7).'/{id}', [CountryController::class, 'editPost'])->name('edit-country');
//        Route::delete(getSecureURL(8).'/{id}', [CountryController::class, 'delete'])->name('delete-country');
//        //Route::post(getSecureURL(2), [CountryController::class, 'upload'])->name('upload-file-attachments');
//    });
//    Route::prefix('city')->group(function () {
//        Route::get(getSecureURL(1), [CityController::class, 'createGet'])->name('city-creation-page');
//        Route::post(getSecureURL(2), [CityController::class, 'createPost'])->name('post-city');
//        Route::get(getSecureURL(4), [CityController::class, 'manageCity'])->name('city-management-page');
//        Route::post('fetch-city', [CityController::class, 'fetchCity'])->name('fetch-city');
//        Route::post(getSecureURL(4), [CityController::class, 'manageCity'])->name('search-city');
//        Route::get(getSecureURL(6).'/{id}', [CityController::class, 'editGet'])->name('city-editor-page');
//        Route::put(getSecureURL(7).'/{id}', [CityController::class, 'editPost'])->name('edit-city');
//        Route::delete(getSecureURL(8).'/{id}', [CityController::class, 'delete'])->name('delete-city');
//        //Route::get('get-cities-by-region', [CityController::class, 'getCitiesByRegion'])->name('get-cities-by-region');
//        //Route::post(getSecureURL(2), [CityController::class, 'upload'])->name('upload-file-attachments');
//    });
//
//    Route::prefix('faq')->group(function () {
//        Route::get(getSecureURL(1), [FaqController::class, 'createGet'])->name('faq-creation-page');
//        Route::post(getSecureURL(2), [FaqController::class, 'createPost'])->name('post-faq');
//        Route::get(getSecureURL(4), [FaqController::class, 'manageFaq'])->name('faq-management-page');
//        Route::post('fetch-faq', [FaqController::class, 'fetchFaq'])->name('fetch-faq');
//        Route::post(getSecureURL(4), [FaqController::class, 'manageFaq'])->name('search-faq');
//        Route::get(getSecureURL(6).'/{id}', [FaqController::class, 'editGet'])->name('faq-editor-page');
//        Route::post(getSecureURL(7).'/{id}', [FaqController::class, 'editPost'])->name('edit-faq');
//        Route::get('preview/{id}', [FaqController::class, 'preview'])->name('preview-faq');
//        //Route::post(getSecureURL(2), [FaqController::class, 'upload'])->name('upload-file-attachments');
//    });
//
//    Route::prefix('partner')->group(function () {
//        Route::get(getSecureURL(1), [PartnerController::class, 'createGet'])->name('partner-creation-page');
//        Route::post(getSecureURL(2), [PartnerController::class, 'createPost'])->name('post-partner');
//        Route::get(getSecureURL(4), [PartnerController::class, 'managePartner'])->name('partner-management-page');
//        Route::post('fetch-partner', [PartnerController::class, 'fetchPartner'])->name('fetch-partner');
//        Route::post(getSecureURL(4), [PartnerController::class, 'managePartner'])->name('search-partner');
//        Route::get(getSecureURL(6).'/{id}', [PartnerController::class, 'editGet'])->name('partner-editor-page');
//        Route::post(getSecureURL(7).'/{id}', [PartnerController::class, 'editPost'])->name('edit-partner');
//        Route::get('preview/{id}', [PartnerController::class, 'preview'])->name('preview-partner');
//        //Route::post(getSecureURL(2), [PartnerController::class, 'upload'])->name('upload-file-attachments');
//    });
//
//    Route::prefix('main-slider')->group(function () {
//        Route::get(getSecureURL(1), [MainSliderController::class, 'createGet'])->name('main-slider-creation-page');
//        Route::post(getSecureURL(2), [MainSliderController::class, 'createPost'])->name('post-main-slider');
//        Route::get(getSecureURL(4), [MainSliderController::class, 'manageMainSlider'])->name('main-slider-management-page');
//        Route::post('fetch-main-slider', [MainSliderController::class, 'fetchMainSlider'])->name('fetch-main-slider');
//        Route::post(getSecureURL(4), [MainSliderController::class, 'manageMainSlider'])->name('search-main-slider');
//        Route::get(getSecureURL(6).'/{id}', [MainSliderController::class, 'editGet'])->name('main-slider-editor-page');
//        Route::post(getSecureURL(7).'/{id}', [MainSliderController::class, 'editPost'])->name('edit-main-slider');
//        Route::get('preview/{id}', [MainSliderController::class, 'preview'])->name('preview-main-slider');
//        //Route::post(getSecureURL(2), [MainSliderController::class, 'upload'])->name('upload-file-attachments');
//    });
//
//    Route::prefix('privacy-policy')->group(function () {
//        Route::get(getSecureURL(1), [PrivacyPolicyController::class, 'createGet'])->name('privacy-policy-creation-page');
//        Route::post(getSecureURL(2), [PrivacyPolicyController::class, 'createPost'])->name('post-privacy-policy');
//        Route::get(getSecureURL(4), [PrivacyPolicyController::class, 'managePrivacyPolicy'])->name('privacy-policy-management-page');
//        Route::post('fetch-privacy-policy', [PrivacyPolicyController::class, 'fetchPrivacyPolicy'])->name('fetch-privacy-policy');
//        Route::post(getSecureURL(4), [PrivacyPolicyController::class, 'managePrivacyPolicy'])->name('search-privacy-policy');
//        Route::get(getSecureURL(6).'/{id}', [PrivacyPolicyController::class, 'editGet'])->name('privacy-policy-editor-page');
//        Route::put(getSecureURL(7).'/{id}', [PrivacyPolicyController::class, 'editPost'])->name('edit-privacy-policy');
//        Route::delete(getSecureURL(8).'/{id}', [PrivacyPolicyController::class, 'delete'])->name('delete-privacy-policy');
//        Route::get('preview/{id}', [PrivacyPolicyController::class, 'preview'])->name('preview-privacy-policy');
//        //Route::post(getSecureURL(2), [PrivacyPolicyController::class, 'upload'])->name('upload-file-attachments');
//    });
//
//    Route::prefix('term-and-condition')->group(function () {
//        Route::get(getSecureURL(1), [TermAndConditionController::class, 'createGet'])->name('term-and-condition-creation-page');
//        Route::post(getSecureURL(2), [TermAndConditionController::class, 'createPost'])->name('post-term-and-condition');
//        Route::get(getSecureURL(4), [TermAndConditionController::class, 'manageTermAndCondition'])->name('term-and-condition-management-page');
//        Route::post('fetch-term-and-condition', [TermAndConditionController::class, 'fetchTermAndCondition'])->name('fetch-term-and-condition');
//        Route::post(getSecureURL(4), [TermAndConditionController::class, 'manageTermAndCondition'])->name('search-term-and-condition');
//        Route::get(getSecureURL(6).'/{id}', [TermAndConditionController::class, 'editGet'])->name('term-and-condition-editor-page');
//        Route::put(getSecureURL(7).'/{id}', [TermAndConditionController::class, 'editPost'])->name('edit-term-and-condition');
//        Route::delete(getSecureURL(8).'/{id}', [TermAndConditionController::class, 'delete'])->name('delete-term-and-condition');
//        Route::get('preview/{id}', [TermAndConditionController::class, 'preview'])->name('preview-term-and-condition');
//        //Route::post(getSecureURL(2), [TermAndConditionController::class, 'upload'])->name('upload-file-attachments');
//    });

    Route::prefix('content')->group(function () {
        Route::put(getSecureURL(9).'/{id}', [ContentsController::class, 'publish'])->name('publish-content');
        Route::put(getSecureURL(10).'/{id}', [ContentsController::class, 'unpublish'])->name('unpublish-content');
        Route::put(getSecureURL(11).'/{id}', [ContentsController::class, 'archive'])->name('archive-content');
        Route::put(getSecureURL('restore').'/{id}', [ContentsController::class, 'restore'])->name('restore-content');
        Route::delete(getSecureURL(8).'/{id}', [ContentsController::class, 'delete'])->name('delete-content');
    });

//    Route::prefix('gallery')->group(function () {
//        Route::post(getSecureURL(2), [PhotoController::class, 'upload'])->name('upload-photo-gallery');
//        Route::get(getSecureURL(4), [PhotoController::class, 'manage'])->name('manage-photo-gallery');
//        Route::delete(getSecureURL(8).'/{photo_id}', [PhotoController::class, 'deletePhoto'])->name('delete-photo');
//        Route::delete(getSecureURL(8).'/{media_id}', [PhotoController::class, 'delete'])->name('delete-media');
//    });

});

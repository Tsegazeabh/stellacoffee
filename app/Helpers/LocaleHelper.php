<?php

use App\Models\DocumentType;
use App\Models\Locale;
use App\Models\PublicationType;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

function getSessionLanguageShortCode()
{
    return Session::get('lang', Config::get('app.fallback_locale'));
}

function getSessionLanguageId()
{
    if(!Session::has('lang_id')){
        $default_locale = Config::get('app.fallback_locale');
        $default_locale_id = Locale::where('short_code', $default_locale)->first()->id;
        return $default_locale_id;
    }
    else {
        return Session::get('lang_id');
    }
}

function translations($jsonTranslationFile)
{
    if (!file_exists($jsonTranslationFile)) {
        return [];
    }

    $translations= json_decode(file_get_contents($jsonTranslationFile), true);

//    if(!empty($translations)) {
//        if (getSessionLanguageShortCode() == 'en') {
//            $documentTypes = DocumentType::get()->pluck('name', 'name')->toArray();
//        } else {
//            $documentTypes = DocumentType::get()->pluck('name_alt', 'name')->toArray();
//        }
//
//        if (getSessionLanguageShortCode() == 'en') {
//            $publicationTypes = PublicationType::get()->pluck('name', 'name')->toArray();
//        } else {
//            $publicationTypes = PublicationType::get()->pluck('name_alt', 'name')->toArray();
//        }
//
//        $documentTypes = array_merge($documentTypes, $publicationTypes);
//
//        $translations = array_merge_recursive($translations, array("menu" => $documentTypes));
//        return $translations;
//    }
    return [];
}

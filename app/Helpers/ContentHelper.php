<?php

use App\Models\Cafe;
use App\Models\Certification;
use App\Models\City;
use App\Models\ContactUsRequest;
use App\Models\Content;
use App\Models\Country;
use App\Models\Faq;
use App\Models\FaqGroup;
use App\Models\MainSlider;
use App\Models\News;
use App\Models\Partner;
use App\Models\PrivacyPolicy;
use App\Models\ProductBlend;
use App\Models\ProductPackage;
use App\Models\QualityControlProcess;
use App\Models\Region;
use App\Models\RoastingGuide;
use App\Models\RoastingMachine;
use App\Models\RoastingProcess;
use App\Models\RoastingService;
use App\Models\History;
use App\Models\ServiceType;
use App\Models\StellaCoffeeOrigin;
use App\Models\SuccessStory;
use App\Models\TermAndCondition;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

function getLeadParagraphWordsLimit()
{
    return Config::get('custom_config.lead_paragraph_words_limit');
}

function getCMSLeadParagraphWordsLimit()
{
    return Config::get('custom_config.cms_lead_paragraph_words_limit');
}

function getFirstNonEmptyParagraph($detailed_desc)
{
    $detailed_desc = preg_replace("/<img[^>]+\>/i", "", $detailed_desc);
    $detailed_desc = preg_replace("/<img[^>]+\>/i", "", $detailed_desc);
    $pattern = "/<p[^>]*>(?:\s|&nbsp;)\/*<\\/p[^>]*>/";
    $detailed_desc = preg_replace($pattern, '', $detailed_desc);
    $detailed_desc = preg_replace('/&nbsp;/i', ' ', $detailed_desc);
    $start = strpos($detailed_desc, '<p>');
    $end = strpos($detailed_desc, '</p>', $start);
    $paragraph = substr($detailed_desc, $start, $end - $start + 4);
    return $paragraph;
}

function getDefaultPagingSize()
{
    return Config::get('custom_config.paging_size', 15);
}

function getRelatedContentsPagingSize()
{
    return Config::get('custom_config.related_contents_paging_size', 8);
}

function getDefaultSortingMethod()
{
    return Config::get('custom_config.default_sorting_method', 'DESC');
}

function getDefaultSortingColumn()
{
    return Config::get('custom_config.default_content_sorting_col', 'created_at');
}

function getContentDetailUrl($content_type, $content_id, $langCode='en')
{
    switch ($content_type) {
        case Certification::class:
            return route('certification-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case History::class:
            return route('history-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ProductBlend::class:
            return route('product-blend-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ProductPackage::class:
            return route('product-package-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case QualityControlProcess::class:
            return route('quality-control-process-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case RoastingGuide::class:
            return route('roasting-guide-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case RoastingMachine::class:
            return route('roasting-machine-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case RoastingProcess::class:
            return route('roasting-process-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case RoastingService::class:
            return route('roasting-service-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case StellaCoffeeOrigin::class:
            return route('stella-coffee-origin-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case SuccessStory::class:
            return route('success-story-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case PrivacyPolicy::class:
            return route('privacy-policy-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case TermAndCondition::class:
            return route('term-and-condition-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case MainSlider::class:
            return route('main-slider-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Cafe::class:
            return route('cafe-service-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case News::class:
            return route('news-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        default:
            return route('home',['lang' => $langCode]);
    }
}

function getModelName($content_type)
{
    switch (strtolower($content_type)) {  //TODO This requires slug operation in addition to lower case
        case 'certification':
            return Certification::class;
        case 'history':
            return History::class;
        case 'product-blend':
        case 'productblend':
            return ProductBlend::class;
        case 'product-package':
        case 'productpackage':
            return ProductPackage::class;
        case 'quality-control-process':
        case 'qualitycontrolprocess':
            return QualityControlProcess::class;
        case 'roasting-guide':
        case 'roastingguide':
            return RoastingGuide::class;
        case 'roasting-machine':
        case 'roastingmachine':
            return RoastingMachine::class;
        case 'roasting-service':
        case 'roastingservice':
            return RoastingService::class;
        case 'roasting-process':
        case 'roastingprocess':
            return RoastingProcess::class;
        case 'stella-coffee-origin':
        case 'stellacoffeeorigin':
            return StellaCoffeeOrigin::class;
        case 'contact-us-request':
        case 'contactusrequest':
            return ContactUsRequest::class;
        case 'success-story':
        case 'successstory':
            return SuccessStory::class;
        case 'privacy-policy':
        case 'privacypolicy':
            return PrivacyPolicy::class;
        case 'term-and-condition':
        case 'termandcondition':
            return TermAndCondition::class;
        case 'mainslider':
            return MainSlider::class;
        case 'cafe':
            return Cafe::class;
        case 'service-type':
        case 'servicetype':
            return ServiceType::class;
        default:
            return News::class;
    }
}

function getTableName($content_type)
{
    switch ($content_type) {  //TODO This requires slug operation in addition to lower case
        case Certification::class:
            return (new Certification)->getTable();
        case History::class:
            return (new History)->getTable();
        case ProductBlend::class:
            return (new ProductBlend)->getTable();
        case ProductPackage::class:
            return (new ProductPackage)->getTable();
        case QualityControlProcess::class:
            return (new QualityControlProcess)->getTable();
        case RoastingGuide::class:
            return (new RoastingGuide)->getTable();
        case RoastingMachine::class:
            return (new RoastingMachine)->getTable();
        case RoastingProcess::class:
            return (new RoastingProcess)->getTable();
        case StellaCoffeeOrigin::class:
            return (new StellaCoffeeOrigin)->getTable();
        case SuccessStory::class:
            return (new SuccessStory)->getTable();
        case PrivacyPolicy::class:
            return (new PrivacyPolicy)->getTable();
        case TermAndCondition::class:
            return (new TermAndCondition)->getTable();
        case MainSlider::class:
            return (new MainSlider)->getTable();
        case Cafe::class:
            return (new Cafe)->getTable();
        case ServiceType::class:
            return (new ServiceType)->getTable();
        default:
            return (new Content())->getTable();
    }
}

function getContentIndexPageComponentName($content_type)
{
    switch ($content_type) {
        case Certification::class:
            return 'Public/Certification/CertificationIndex';
        case History::class:
            return 'Public/History/HistoryIndex';
        case ProductBlend::class:
            return 'Public/ProductBlend/ProductBlendIndex';
        case ProductPackage::class:
            return 'Public/ProductPackage/ProductPackageIndex';
        case QualityControlProcess::class:
            return 'Public/QualityControlProcess/QualityControlProcessIndex';
        case RoastingGuide::class:
            return 'Public/RoastingGuide/RoastingGuideIndex';
        case RoastingService::class:
            return 'Public/RoastingService/RoastingServiceIndex';
        case RoastingMachine::class:
            return 'Public/RoastingMachine/RoastingMachineIndex';
        case RoastingProcess::class:
            return 'Public/RoastingProcess/RoastingProcessIndex';
        case StellaCoffeeOrigin::class:
            return 'Public/StellaCoffeeOrigin/StellaCoffeeOriginIndex';
        case SuccessStory::class:
            return 'Public/SuccessStory/SuccessStoryIndex';
        case Faq::class:
            return 'Public/Faq/FaqIndex';
        case MainSlider::class:
            return 'Public/MainSlider/MainSliderIndex';
        case PrivacyPolicy::class:
            return 'Public/PrivacyPolicy/PrivacyPolicyIndex';
        case TermAndCondition::class:
            return 'Public/TermAndCondition/TermAndConditionIndex';
        case Cafe::class:
            return 'Public/Cafe/CafeIndex';
        default:
            return 'Public/News/NewsIndex';
    }
}

function getFirstImageURL($rich_text_content, $content_type)
{
    if (!empty($rich_text_content)) {
        $dom = new \DOMDocument();
        $dom->loadHTML($rich_text_content);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            $image_url = $image->getAttribute('src');
            $url_parts = explode('/', $image_url);
            $image_name = array_pop($url_parts);
            array_push($url_parts, 'thumbs', $image_name);
            $image_url = implode('/', $url_parts);
            return $image_url;
        }
    }
    switch ($content_type) {
        case 'App\ForumTopic':
        case 'App\VacancyAnnouncement':
        case 'App\BidAnnouncement':
            return null;
        default:
            return getDefaultAppImagePath();
    }
}

function getDefaultAppImagePath()
{
    return array(
        'src' => asset('images/logo.jpg')
    );
}

function getFirstImageSrcsets($rich_text_content)
{
    if (!empty($rich_text_content)) {
        $dom = new \DOMDocument();
        @$dom->loadHTML($rich_text_content, LIBXML_NOWARNING);
        $images = $dom->getElementsByTagName('img');
        if (!empty($images) && $images->count() > 0) {
            return array(
                'src' => $images->item(0)->getAttribute('src'),
                'srcset' => $images->item(0)->getAttribute('srcset'),
                'width' => $images->item(0)->getAttribute('width'),
                'sizes' => $images->item(0)->getAttribute('sizes'),
                'alt' => $images->item(0)->getAttribute('alt')
            );
            return $images->item(0)->nodeValue;
        }
    }
    return getDefaultAppImagePath();
}

function getSearchableContentTypes()
{
    return [
        News::class,
        Certification::class,
        History::class,
        ProductBlend::class,
        QualityControlProcess::class,
        RoastingProcess::class,
        RoastingMachine::class,
        RoastingGuide::class,
        StellaCoffeeOrigin::class,
        SuccessStory::class,
        Cafe::class,
        ServiceType::class,
//        Vacancy::class,
//        Tender::class,
    ];
}

function getContentTypesForRSSFeeds()
{
    return [
        News::class,
        Certification::class,
        History::class,
        ProductBlend::class,
        QualityControlProcess::class,
        RoastingProcess::class,
        RoastingMachine::class,
        RoastingGuide::class,
        StellaCoffeeOrigin::class,
        SuccessStory::class,
        Cafe::class
//        Vacancy::class,
//        Tender::class,
    ];
}

function getModelShortName($model_type)
{
    switch ($model_type) {
        case Certification::class:
            return trans('models.Certification');
        case History::class:
            return trans('models.History');
        case ProductBlend::class:
            return trans('models.ProductBlend');
        case ProductPackage::class:
            return trans('models.ProductPackage');
        case QualityControlProcess::class:
            return trans('models.QualityControlProcess');
        case RoastingGuide::class:
            return trans('models.RoastingGuide');
        case RoastingMachine::class:
            return trans('models.RoastingMachine');
        case RoastingProcess::class:
            return trans('models.RoastingProcess');
        case StellaCoffeeOrigin::class:
            return trans('models.StellaCoffeeOrigin');
        case SuccessStory::class:
            return trans('models.SuccessStory');
        case ContactUsRequest::class:
            return trans('models.ContactUsRequest');
        case News::class:
            return trans('models.News');
        case Faq::class:
            return trans('models.Faq');
        case FaqGroup::class:
            return trans('models.FaqGroup');
        case Partner::class:
            return trans('models.Partner');
        case MainSlider::class:
            return trans('models.MainSlider');
        case PrivacyPolicy::class:
            return trans('models.PrivacyPolicy');
        case TermAndCondition::class:
            return trans('models.TermAndCondition');
        case Cafe::class:
            return trans('models.Cafe');
        case ServiceType::class:
            return trans('models.ServiceType');
        default:
            return trans('models.Content');
    }
}

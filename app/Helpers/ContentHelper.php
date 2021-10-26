<?php

use App\Http\Controllers\CMS\PrivacyPolicyController;
use App\Http\Controllers\CMS\ServiceCharterController;
use App\Models\BillComplaint;
use App\Models\BillInformation;
use App\Models\Billing;
use App\Models\CitizenEngagement;
use App\Models\City;
use App\Models\ComplaintHandling;
use App\Models\ContactDetails;
use App\Models\ContactUsRequest;
use App\Models\Content;
use App\Models\Country;
use App\Models\CustomerAnnouncement;
use App\Models\CustomerRightAndDuty;
use App\Models\CustomerServiceCenter;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\EaseOfDoingBusiness;
use App\Models\ElectricalTip;
use App\Models\ElectricityTariff;
use App\Models\Events;
use App\Models\Faq;
use App\Models\FaqGroup;
use App\Models\GettingElectricity;
use App\Models\ImportantLink;
use App\Models\MainSlider;
use App\Models\News;
use App\Models\OrganizationalStructure;
use App\Models\Partner;
use App\Models\PaymentOption;
use App\Models\PaymentType;
use App\Models\PopupContent;
use App\Models\Postpaid;
use App\Models\PowerInterruption;
use App\Models\Prepaid;
use App\Models\PressRelease;
use App\Models\PrivacyPolicy;
use App\Models\ProjectAndProgram;
use App\Models\Publication;
use App\Models\PublicationType;
use App\Models\Region;
use App\Models\ServiceCharter;
use App\Models\ServiceType;
use App\Models\SocialResponsibility;
use App\Models\Speech;
use App\Models\AboutUs;
use App\Models\Profile;
use App\Models\History;
use App\Models\CeoMessage;
use App\Models\Innovation;
use App\Models\StaffAnnouncement;
use App\Models\Subcity;
use App\Models\Tender;
use App\Models\TermAndCondition;
use App\Models\Vacancy;
use App\Models\Woreda;
use App\Models\Zone;
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
        case News::class:
            return route('news-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Events::class:
            return route('event-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case PressRelease::class:
            return route('press-release-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Speech::class:
            return route('speech-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case AboutUs::class:
            return route('about-us-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Profile::class:
            return route('profile-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case History::class:
            return route('history-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case CeoMessage::class:
            return route('ceo-message-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Innovation::class:
            return route('innovation-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case OrganizationalStructure::class:
            return route('organizational-structure-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ServiceCharter::class:
            return route('service-charter-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Postpaid::class:
            return route('postpaid-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Prepaid::class:
            return route('prepaid-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case BillInformation::class:
            return route('bill-information-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case BillComplaint::class:
            return route('bill-complaint-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ContactDetails::class:
            return route('contact-details-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case CustomerServiceCenter::class:
            return route('customer-service-center-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case GettingElectricity::class:
            return route('getting-electricity-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case PaymentOption::class:
            return route('payment-option-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Billing::class:
            return route('billing-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case PowerInterruption::class:
            return route('power-interruption-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ElectricityTariff::class:
            return route('electricity-tariff-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ComplaintHandling::class:
            return route('complaint-handling-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case CustomerRightAndDuty::class:
            return route('customer-right-and-duty-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ElectricalTip::class:
            return route('electrical-tip-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case EaseOfDoingBusiness::class:
            return route('ease-of-doing-business-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case ProjectAndProgram::class:
            return route('project-and-program-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case SocialResponsibility::class:
            return route('social-responsibility-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Document::class:
            return route('document-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Publication::class:
            return route('publication-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case CitizenEngagement::class:
            return route('citizen-engagement-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case CustomerAnnouncement::class:
            return route('customer-announcement-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case StaffAnnouncement::class:
            return route('staff-announcement-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Vacancy::class:
            return route('vacancy-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Tender::class:
            return route('tender-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case Faq::class:
            return route('faq-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case MainSlider::class:
            return route('main-slider-detail', [
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
        case ImportantLink::class:
            return route('important-link-detail', [
                'contentId' => $content_id,
                'lang' => $langCode
            ]);
        case PopupContent::class:
            return route('popup-content-detail', [
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
        case 'events':
            return Events::class;
        case 'press-release':
        case 'pressrelease':
            return PressRelease::class;
        case 'speeches':
            return Speech::class;
        case 'about-us':
        case 'aboutus':
            return AboutUs::class;
        case 'history':
            return History::class;
        case 'profile':
            return Profile::class;
        case 'ceo-message':
        case 'ceomessage':
            return CeoMessage::class;
        case 'innovation':
            return Innovation::class;
        case 'organizational-structure':
        case 'organizationalstructure':
            return OrganizationalStructure::class;
        case 'service-charter':
        case 'servicecharter':
            return ServiceCharter::class;
        case 'postpaid':
            return Postpaid::class;
        case 'prepaid':
            return Prepaid::class;
        case 'bill-information':
        case 'billinformation':
            return BillInformation::class;
        case 'bill-complaint':
        case 'billcomplaint':
            return BillComplaint::class;
        case 'contact-details':
        case 'contactdetails':
            return ContactDetails::class;
        case 'contactusrequest':
        case 'contact-us-request':
            return ContactUsRequest::class;
        case 'payment-type':
        case 'paymenttype':
            return PaymentType::class;
        case 'service-type':
        case 'servicetype':
            return ServiceType::class;
        case 'country':
            return Country::class;
        case 'region':
            return Region::class;
        case 'woreda':
            return Woreda::class;
        case 'zone':
            return Zone::class;
        case 'city':
            return City::class;
        case 'subcity':
            return Subcity::class;
        case 'customer-service-center':
        case 'customerservicecenter':
            return CustomerServiceCenter::class;
        case 'getting-electricity':
        case 'gettingelectricity':
            return GettingElectricity::class;
        case 'payment-option':
        case 'paymentoption':
            return PaymentOption::class;
        case 'billing':
            return Billing::class;
        case 'power-interruption':
        case 'powerinterruption':
            return PowerInterruption::class;
        case 'electricity-tariff':
        case 'electricitytariff':
            return ElectricityTariff::class;
        case 'complaint-handling':
        case 'complainthandling':
            return ComplaintHandling::class;
        case 'customer-right-and-duty':
        case 'customerrightandduty':
            return CustomerRightAndDuty::class;
        case 'electrical-tip':
        case 'electricaltip':
            return ElectricalTip::class;
        case 'ease-of-doing-business':
        case 'easeofdoingbusiness':
            return EaseOfDoingBusiness::class;
        case 'project-and-program':
        case 'projectandprogram':
            return ProjectAndProgram::class;
        case 'social-responsibility':
        case 'socialresponsibility':
            return SocialResponsibility::class;
        case 'document':
            return Document::class;
        case 'publication':
            return Publication::class;
        case 'citizenengagement':
        case 'citizen-engagement':
            return CitizenEngagement::class;
        case 'publication-type':
        case 'publicationtype':
            return PublicationType::class;
        case 'document-type':
        case 'documenttype':
            return DocumentType::class;
        case 'customer-announcement':
        case 'customerannouncement':
            return CustomerAnnouncement::class;
        case 'staff-announcement':
        case 'staffannouncement':
            return StaffAnnouncement::class;
        case 'vacancy':
            return Vacancy::class;
        case 'tender':
            return Tender::class;
        case 'faq':
            return Faq::class;
        case 'faq-group':
        case 'faqgroup':
            return FaqGroup::class;
        case 'partner':
            return Partner::class;
        case 'main-slider':
        case 'mainslider':
            return MainSlider::class;
        case 'privacy-policy':
            return PrivacyPolicy::class;
        case 'term-and-condition':
            return TermAndCondition::class;
        case 'important-link':
            return ImportantLink::class;
        case 'popup-content':
            return PopupContent::class;
        default:
            return News::class;
    }
}

function getTableName($content_type)
{
    switch ($content_type) {  //TODO This requires slug operation in addition to lower case
        case Events::class:
            return (new Events)->getTable();
        case PressRelease::class:
            return (new PressRelease)->getTable();
        case Speech::class:
            return (new Speech)->getTable();
        case AboutUs::class:
            return (new AboutUs)->getTable();
        case History::class:
            return (new History)->getTable();
        case Profile::class:
            return (new Profile)->getTable();
        case CeoMessage::class:
            return (new CeoMessage)->getTable();
        case Innovation::class:
            return (new Innovation)->getTable();
        case OrganizationalStructure::class:
            return (new OrganizationalStructure)->getTable();
        case ServiceCharter::class:
            return (new ServiceCharter)->getTable();
        case Postpaid::class:
            return (new Postpaid)->getTable();
        case Prepaid::class:
            return (new Prepaid)->getTable();
        case BillInformation::class:
            return (new BillInformation)->getTable();
        case BillComplaint::class:
            return (new BillComplaint)->getTable();
        case ContactDetails::class:
            return (new ContactDetails)->getTable();
        case ContactUsRequest::class:
            return (new ContactUsRequest)->getTable();
        case PaymentType::class:
            return (new PaymentType)->getTable();
        case ServiceType::class:
            return (new ServiceType)->getTable();
        case Country::class:
            return (new Country)->getTable();
        case Region::class:
            return (new Region)->getTable();
        case Woreda::class:
            return (new Woreda)->getTable();
        case Zone::class:
            return (new Zone)->getTable();
        case City::class:
            return (new City)->getTable();
        case  CustomerServiceCenter::class:
            return (new CustomerServiceCenter)->getTable();
        case GettingElectricity::class:
            return (new GettingElectricity)->getTable();
        case PaymentOption::class:
            return (new PaymentOption)->getTable();
        case Billing::class:
            return (new Billing)->getTable();
        case PowerInterruption::class:
            return (new PowerInterruption)->getTable();
        case ElectricityTariff::class:
            return (new ElectricityTariff)->getTable();
        case ComplaintHandling::class:
            return (new ComplaintHandling)->getTable();
        case CustomerRightAndDuty::class:
            return (new CustomerRightAndDuty)->getTable();
        case ElectricalTip::class:
            return (new ElectricalTip)->getTable();
        case EaseOfDoingBusiness::class:
            return (new EaseOfDoingBusiness)->getTable();
        case ProjectAndProgram::class:
            return (new ProjectAndProgram)->getTable();
        case SocialResponsibility::class:
            return (new SocialResponsibility)->getTable();
        case Document::class:
            return (new Document)->getTable();
        case Publication::class:
            return (new Publication)->getTable();
        case CitizenEngagement::class:
            return (new CitizenEngagement)->getTable();
        case PublicationType::class:
            return (new PublicationType)->getTable();
        case DocumentType::class:
            return (new DocumentType)->getTable();
        case CustomerAnnouncement::class:
            return (new CustomerAnnouncement)->getTable();
        case StaffAnnouncement::class:
            return (new StaffAnnouncement)->getTable();
        case News::class:
            return (new News)->getTable();
        case Faq::class:
            return (new Faq)->getTable();
        case FaqGroup::class:
            return (new FaqGroup)->getTable();
        case Partner::class:
            return (new Partner)->getTable();
        case MainSlider::class:
            return (new MainSlider)->getTable();
        case Subcity::class:
            return (new Subcity)->getTable();
        case PrivacyPolicy::class:
            return (new PrivacyPolicy)->getTable();
        case TermAndCondition::class:
            return (new TermAndCondition)->getTable();
        case ImportantLink::class:
            return (new ImportantLink)->getTable();
        case PopupContent::class:
            return (new PopupContent)->getTable();
        default:
            return (new Content())->getTable();
    }
}

function getContentIndexPageComponentName($content_type)
{
    switch ($content_type) {
        case Events::class:
            return 'Public/Event/EventIndex';
        case PressRelease::class:
            return 'Public/PressRelease/PressReleaseIndex';
        case Speech::class:
            return 'Public/Speech/SpeechIndex';
        case AboutUs::class:
            return 'Public/AboutUs/AboutUsIndex';
        case Profile::class:
            return 'Public/Profile/ProfileIndex';
        case History::class:
            return 'Public/History/HistoryIndex';
        case CeoMessage::class:
            return 'Public/CeoMessage/CeoMessageIndex';
        case Innovation::class:
            return 'Public/Innovation/InnovationIndex';
        case OrganizationalStructure::class:
            return 'Public/OrganizationalStructure/OrganizationalStructureIndex';
        case ServiceCharter::class:
            return 'Public/ServiceCharter/ServiceCharterIndex';
        case Postpaid::class:
            return 'Public/Postpaid/PostpaidIndex';
        case Prepaid::class:
            return 'Public/Prepaid/PrepaidIndex';
        case BillInformation::class:
            return 'Public/BillInformation/BillInformationIndex';
        case BillComplaint::class:
            return 'Public/BillComplaint/BillComplaintIndex';
        case ContactDetails::class:
            return 'Public/ContactDetails/ContactDetailsIndex';
        case CustomerServiceCenter::class:
            return 'Public/CustomerServiceCenter/CustomerServiceCenterIndex';
        case GettingElectricity::class:
            return 'Public/GettingElectricity/GettingElectricityIndex';
        case PaymentOption::class:
            return 'Public/PaymentOption/PaymentOptionIndex';
        case Billing::class:
            return 'Public/Billing/BillingIndex';
        case PowerInterruption::class:
            return 'Public/PowerInterruption/PowerInterruptionIndex';
        case ElectricityTariff::class:
            return 'Public/ElectricityTariff/ElectricityTariffIndex';
        case ComplaintHandling::class:
            return 'Public/ComplaintHandling/ComplaintHandlingIndex';
        case CustomerRightAndDuty::class:
            return 'Public/CustomerRightAndDuty/CustomerRightAndDutyIndex';
        case ElectricalTip::class:
            return 'Public/ElectricalTip/ElectricalTipIndex';
        case EaseOfDoingBusiness::class:
            return 'Public/EaseOfDoingBusiness/EaseOfDoingBusinessIndex';
        case ProjectAndProgram::class:
            return 'Public/ProjectAndProgram/ProjectAndProgramIndex';
        case SocialResponsibility::class:
            return 'Public/SocialResponsibility/SocialResponsibilityIndex';
        case Document::class:
            return 'Public/Document/DocumentIndex';
        case Publication::class:
            return 'Public/Publication/PublicationIndex';
        case CitizenEngagement::class:
            return 'Public/CitizenEngagement/CitizenEngagementIndex';
        case CustomerAnnouncement::class:
            return 'Public/CustomerAnnouncement/CustomerAnnouncementIndex';
        case StaffAnnouncement::class:
            return 'Public/StaffAnnouncement/StaffAnnouncementIndex';
        case Vacancy::class:
            return 'Public/Vacancy/VacancyIndex';
        case Tender::class:
            return 'Public/Tender/TenderIndex';
        case Faq::class:
            return 'Public/Faq/FaqIndex';
        case MainSlider::class:
            return 'Public/MainSlider/MainSliderIndex';
        case PrivacyPolicy::class:
            return 'Public/PrivacyPolicy/PrivacyPolicyIndex';
        case TermAndCondition::class:
            return 'Public/TermAndCondition/TermAndConditionIndex';
        case ImportantLink::class:
            return 'Public/ImportantLink/ImportantLinkIndex';
        case PopupContent::class:
            return 'Public/PopupContent/PopupContentIndex';
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
        'src' => asset('images/logo.png')
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
        Events::class,
        PressRelease::class,
        Speech::class,
        Profile::class,
        ServiceCharter::class,
        Innovation::class,
        CeoMessage::class,
        Postpaid::class,
        Prepaid::class,
        BillInformation::class,
        BillComplaint::class,
        PaymentOption::class,
        Billing::class,
        GettingElectricity::class,
        CustomerAnnouncement::class,
        ElectricityTariff::class,
        ElectricalTip::class,
        EaseOfDoingBusiness::class,
        CustomerRightAndDuty::class,
        ProjectAndProgram::class,
        SocialResponsibility::class,
        CitizenEngagement::class,
        StaffAnnouncement::class,
        ImportantLink::class,
        PopupContent::class,
//        Vacancy::class,
//        Tender::class,
        Document::class,
        Publication::class
    ];
}

function getContentTypesForRSSFeeds()
{
    return [
        News::class,
        Events::class,
        PressRelease::class,
        Speech::class,
        Profile::class,
        ServiceCharter::class,
        Innovation::class,
        CeoMessage::class,
        Postpaid::class,
        Prepaid::class,
        BillInformation::class,
        BillComplaint::class,
        PaymentOption::class,
        Billing::class,
        GettingElectricity::class,
        CustomerAnnouncement::class,
        ElectricityTariff::class,
        ElectricalTip::class,
        EaseOfDoingBusiness::class,
        CustomerRightAndDuty::class,
        ProjectAndProgram::class,
        SocialResponsibility::class,
        CitizenEngagement::class,
        StaffAnnouncement::class,
        ImportantLink::class,
        PopupContent::class,
//        Vacancy::class,
//        Tender::class,
        Document::class,
        Publication::class
    ];
}

function getModelShortName($model_type)
{
    switch ($model_type) {
        case Events::class:
            return trans('models.Events');
        case PressRelease::class:
            return trans('models.PressRelease');
        case Speech::class:
            return trans('models.Speech');
        case AboutUs::class:
            return trans('models.AboutUs');
        case History::class:
            return trans('models.History');
        case Profile::class:
            return trans('models.Profile');
        case CeoMessage::class:
            return trans('models.CeoMessage');
        case Innovation::class:
            return trans('models.Innovation');
        case OrganizationalStructure::class:
            return trans('models.OrganizationalStructure');
        case ServiceCharter::class:
            return trans('models.ServiceCharter');
        case Postpaid::class:
            return trans('models.Postpaid');
        case Prepaid::class:
            return trans('models.Prepaid');
        case BillInformation::class:
            return trans('models.BillInformation');
        case BillComplaint::class:
            return trans('models.BillComplaint');
        case ContactDetails::class:
            return trans('models.ContactDetails');
        case ContactUsRequest::class:
            return trans('models.ContactUsRequest');
        case PaymentType::class:
            return trans('models.PaymentType');
        case ServiceType::class:
            return trans('models.ServiceType');
        case Country::class:
            return trans('models.Country');
        case Region::class:
            return trans('models.Region');
        case Woreda::class:
            return trans('models.Woreda');
        case Zone::class:
            return trans('models.Zone');
        case City::class:
            return trans('models.City');
        case  CustomerServiceCenter::class:
            return trans('models.CustomerServiceCenter');
        case GettingElectricity::class:
            return trans('models.GettingElectricity');
        case PaymentOption::class:
            return trans('models.PaymentOption');
        case Billing::class:
            return trans('models.Billing');
        case PowerInterruption::class:
            return trans('models.PowerInterruption');
        case ElectricityTariff::class:
            return trans('models.ElectricityTariff');
        case ComplaintHandling::class:
            return trans('models.ComplaintHandling');
        case CustomerRightAndDuty::class:
            return trans('models.CustomerRightAndDuty');
        case ElectricalTip::class:
            return trans('models.ElectricalTip');
        case EaseOfDoingBusiness::class:
            return trans('models.EaseOfDoingBusiness');
        case ProjectAndProgram::class:
            return trans('models.ProjectAndProgram');
        case SocialResponsibility::class:
            return trans('models.SocialResponsibility');
        case Document::class:
            return trans('models.Document');
        case Publication::class:
            return trans('models.Publication');
        case CitizenEngagement::class:
            return trans('models.CitizenEngagement');
        case PublicationType::class:
            return trans('models.PublicationType');
        case DocumentType::class:
            return trans('models.DocumentType');
        case CustomerAnnouncement::class:
            return trans('models.CustomerAnnouncement');
        case StaffAnnouncement::class:
            return trans('models.StaffAnnouncement');
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
        case Subcity::class:
            return trans('models.Subcity');
        case PrivacyPolicy::class:
            return trans('models.PrivacyPolicy');
        case TermAndCondition::class:
            return trans('models.TermAndCondition');
        case Vacancy::class:
            return trans('models.Vacancy');
        case Tender::class:
            return trans('models.Tender');
        case ImportantLink::class:
            return trans('models.ImportantLink');
        case PopupContent::class:
            return trans('models.PopupContent');
        default:
            return trans('models.Content');
    }
}

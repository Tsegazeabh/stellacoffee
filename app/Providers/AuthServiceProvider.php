<?php

namespace App\Providers;

use App\Models\AboutUs;
use App\Models\BillComplaint;
use App\Models\BillInformation;
use App\Models\Billing;
use App\Models\CeoMessage;
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
use App\Models\History;
use App\Models\ImportantLink;
use App\Models\Innovation;
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
use App\Models\ProductBlend;
use App\Models\ProductPackage;
use App\Models\Profile;
use App\Models\ProjectAndProgram;
use App\Models\Publication;
use App\Models\PublicationType;
use App\Models\Region;
use App\Models\RoastingGuide;
use App\Models\RoastingMachine;
use App\Models\RoastingProcess;
use App\Models\RoastingService;
use App\Models\ServiceCharter;
use App\Models\ServiceType;
use App\Models\SocialResponsibility;
use App\Models\Speech;
use App\Models\StaffAnnouncement;
use App\Models\StellaCoffeeOrigin;
use App\Models\Tender;
use App\Models\Vacancy;
use App\Models\Woreda;
use App\Models\Zone;
use App\Policies\AboutUsPolicy;
use App\Policies\BillComplaintPolicy;
use App\Policies\BillInformationPolicy;
use App\Policies\BillingPolicy;
use App\Policies\CeoMessagePolicy;
use App\Policies\CitizenEngagementPolicy;
use App\Policies\CityPolicy;
use App\Policies\ComplaintHandlingPolicy;
use App\Policies\ContactDetailsPolicy;
use App\Policies\ContactUsRequestPolicy;
use App\Policies\ContentPolicy;
use App\Policies\CountryPolicy;
use App\Policies\CustomerAnnouncementPolicy;
use App\Policies\CustomerRightAndDutyPolicy;
use App\Policies\CustomerServiceCenterPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\DocumentTypePolicy;
use App\Policies\EaseOfDoingBusinessPolicy;
use App\Policies\ElectricalTipPolicy;
use App\Policies\ElectricityTariffPolicy;
use App\Policies\EventsPolicy;
use App\Policies\FaqGroupPolicy;
use App\Policies\FaqPolicy;
use App\Policies\GettingElectricityPolicy;
use App\Policies\HistoryPolicy;
use App\Policies\ImportantLinkPolicy;
use App\Policies\InnovationPolicy;
use App\Policies\MainSliderPolicy;
use App\Policies\NewsPolicy;
use App\Policies\OrganizationalStructurePolicy;
use App\Policies\PartnerPolicy;
use App\Policies\PaymentOptionPolicy;
use App\Policies\PaymentTypePolicy;
use App\Policies\PopupContentPolicy;
use App\Policies\PostpaidPolicy;
use App\Policies\PowerInterruptionPolicy;
use App\Policies\PrepaidPolicy;
use App\Policies\PressReleasePolicy;
use App\Policies\ProductBlendPolicy;
use App\Policies\ProductPackagePolicy;
use App\Policies\ProfilePolicy;
use App\Policies\ProjectAndProgramPolicy;
use App\Policies\PublicationPolicy;
use App\Policies\PublicationTypePolicy;
use App\Policies\RegionPolicy;
use App\Policies\RoastingGuidePolicy;
use App\Policies\RoastingMachinePolicy;
use App\Policies\RoastingProcessPolicy;
use App\Policies\RoastingServicePolicy;
use App\Policies\ServiceCharterPolicy;
use App\Policies\ServiceTypePolicy;
use App\Policies\SocialResponsibilityPolicy;
use App\Policies\SpeechPolicy;
use App\Policies\StaffAnnouncementPolicy;
use App\Policies\StellaCoffeOriginPolicy;
use App\Policies\TenderPolicy;
use App\Policies\VacancyPolicy;
use App\Policies\WoredaPolicy;
use App\Policies\ZonePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Content::class => ContentPolicy::class,
        ContactUsRequest::class => ContactUsRequestPolicy::class,
        History::class => HistoryPolicy::class,
        ProductBlend::class=>ProductBlendPolicy::class,
        ProductPackage::class=>ProductPackagePolicy::class,
        StellaCoffeeOrigin::class=>StellaCoffeOriginPolicy::class,
        RoastingProcess::class=>RoastingProcessPolicy::class,
        RoastingMachine::class=>RoastingMachinePolicy::class,
        RoastingGuide::class=>RoastingGuidePolicy::class,
        RoastingService::class=>RoastingServicePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

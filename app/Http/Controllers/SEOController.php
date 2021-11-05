<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Events;
use App\Models\Faq;
use App\Models\News;
use App\Models\Photo;
use App\Models\PressRelease;
use App\Models\PrivacyPolicy;
use App\Models\Publication;
use App\Models\PublicationType;
use App\Models\Speech;
use App\Models\TermAndCondition;
use Carbon\Carbon;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SEOController extends Controller
{
    //

    public function __construct()
    {
    }

    public function generateSitemap()
    {
        try {
            $sitemap = App::make('sitemap');
            $sitemap->setCache('laravel.sitemap', 60);

            // check if there is cached sitemap and build new only if is not
            if (!$sitemap->isCached()) {

                // add item to the sitemap (url, date, priority, freq)
                $landingPageTranslations = [
                    ['language' => 'am', 'url' => route('home', ['lang' => 'am'])],
                ];
                $sitemap->add(route('home', ['lang' => 'en']), Carbon::now(), '1.0', 'daily', [], null, $landingPageTranslations);

                /* Company */
                $aboutusPageTranslations = [
                    ['language' => 'am', 'url' => route('latest-about-us', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-about-us', ['lang' => 'en']), Carbon::now(), '1.0', 'monthly', [], null, $aboutusPageTranslations);

                $orgStructurePageTranslations = [
                    ['language' => 'am', 'url' => route('latest-organizational-structure', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-organizational-structure', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $orgStructurePageTranslations);

                $profilePageTranslations = [
                    ['language' => 'am', 'url' => route('latest-profile', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-profile', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $profilePageTranslations);

                $historyPageTranslations = [
                    ['language' => 'am', 'url' => route('history-index', ['lang' => 'am'])],
                ];
                $sitemap->add(route('history-index', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $historyPageTranslations);

                $serviceCharterPageTranslations = [
                    ['language' => 'am', 'url' => route('latest-service-charter', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-service-charter', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $serviceCharterPageTranslations);

                $innovationPageTranslations = [
                    ['language' => 'am', 'url' => route('latest-innovation', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-innovation', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $innovationPageTranslations);

                $ceoMessagePageTranslations = [
                    ['language' => 'am', 'url' => route('latest-ceo-message', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-ceo-message', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $ceoMessagePageTranslations);

                $contactOfficesPageTranslations = [
                    ['language' => 'am', 'url' => route('latest-contact-details', ['lang' => 'am'])],
                ];
                $sitemap->add(route('latest-contact-details', ['lang' => 'en']), Carbon::now(), '0.5', 'monthly', [], null, $contactOfficesPageTranslations);

                /*Customer Services*/
                $postPaidPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'postpaid',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'postpaid',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $postPaidPageTranslations);

                $prepaidPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'prepaid',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'prepaid',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $prepaidPageTranslations);

                $billInfoPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'bill-information',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'bill-information',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $billInfoPageTranslations);

                $billComplaintPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'bill-complaint',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'bill-complaint',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $billComplaintPageTranslations);

                $customerServiceCentersPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('latest-customer-service-center', [
                                'service_center_type' => 2,
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('latest-customer-service-center', [
                    'service_center_type' => 2,
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $customerServiceCentersPageTranslations);

                $billSalesOfficePageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('latest-customer-service-center', [
                                'service_center_type' => 1,
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('latest-customer-service-center', [
                    'service_center_type' => 1,
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $billSalesOfficePageTranslations);

                $paymentOptionsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'payment-option',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'payment-option',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $paymentOptionsPageTranslations);

                $billingPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'billing',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'billing',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $billingPageTranslations);

                $gettingElectricityPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'getting-electricity',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'getting-electricity',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $gettingElectricityPageTranslations);

                $customerAnnouncementPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('latest-customer-announcement', [
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('latest-customer-announcement', [
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $customerAnnouncementPageTranslations);

                /**Public Information**/

                $electricityTariffPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'electricity-tariff',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'electricity-tariff',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $electricityTariffPageTranslations);


                $compliantHandlingPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'complaint-handling',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'complaint-handling',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $compliantHandlingPageTranslations);

                $customerRightAndDutyPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'customer-right-and-duty',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'customer-right-and-duty',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $customerRightAndDutyPageTranslations);

                $electricTipsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'electrical-tip',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'electrical-tip',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $electricTipsPageTranslations);

                $easeOfDoingBusinessPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'ease-of-doing-business',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'ease-of-doing-business',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $easeOfDoingBusinessPageTranslations);

                $projectAndProgramsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'project-and-program',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'project-and-program',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $projectAndProgramsPageTranslations);

                $csrPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'social-responsibility',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'social-responsibility',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $csrPageTranslations);

                $citizenEngagementPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'citizen-engagement',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'citizen-engagement',
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $citizenEngagementPageTranslations);

                $powerInterruptionPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('power-interruption-index', [
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('power-interruption-index', [
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $powerInterruptionPageTranslations);

                $staffAnnouncementPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('latest-staff-announcement', [
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('latest-staff-announcement', [
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $staffAnnouncementPageTranslations);

                $vacancyAnnouncementPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('latest-vacancy', [
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('latest-vacancy', [
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $vacancyAnnouncementPageTranslations);

                $tendersPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('latest-tender', [
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('latest-tender', [
                    'lang' => 'en'
                ]), Carbon::now(), '0.5', 'monthly', [], null, $tendersPageTranslations);

                /**Documents and Publications**/
                $documentTypes = DocumentType::get();

                $latestDocumentPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [Document::class])->published()->exists()){
                    $latestDocumentPublishedDate = Content::whereHasMorph('contentable', [Document::class])->published()->orderBy('published_at')->first()->published_at;
                }

                foreach ($documentTypes as $documentType) {

                    $documentPageTranslations = [
                        [
                            'language' => 'am',
                            'url' => route('latest-document', [
                                    'type' => $documentType->id,
                                    'lang' => 'am'
                                ]
                            )
                        ],
                    ];
                    $sitemap->add(route('latest-document', [
                        'type' => $documentType->id,
                        'lang' => 'en'
                    ]), $latestDocumentPublishedDate, '0.9', 'weekly', [], null, $documentPageTranslations);
                }

                $publicationTypes = PublicationType::get();

                $latestPublicationPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [Publication::class])->published()->exists()){
                    $latestPublicationPublishedDate = Content::whereHasMorph('contentable', [Publication::class])->published()->orderBy('published_at')->first()->published_at;
                }

                foreach ($publicationTypes as $publicationType) {

                    $publicationPageTranslations = [
                        [
                            'language' => 'am',
                            'url' => route('latest-publication', [
                                    'type' => $publicationType->id,
                                    'lang' => 'am'
                                ]
                            )
                        ],
                    ];
                    $sitemap->add(route('latest-publication', [
                        'type' => $publicationType->id,
                        'lang' => 'en'
                    ]), $latestPublicationPublishedDate, '0.9', 'weekly', [], null, $publicationPageTranslations);
                }

                /**Media Centers**/

                $latestNewsPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [News::class])->published()->exists()){
                    $latestNewsPublishedDate = Content::whereHasMorph('contentable', [News::class])->published()->orderBy('published_at')->first()->published_at;
                }

                $newsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'news',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'news',
                    'lang' => 'en'
                ]), $latestNewsPublishedDate, '1.0', 'daily', [], null, $newsPageTranslations);

                $latestPressReleasePublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [PressRelease::class])->published()->exists()){
                    $latestPressReleasePublishedDate = Content::whereHasMorph('contentable', [PressRelease::class])->published()->orderBy('published_at')->first()->published_at;
                }
                $pressReleasePageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'press-release',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'press-release',
                    'lang' => 'en'
                ]), $latestPressReleasePublishedDate, '1.0', 'daily', [], null, $pressReleasePageTranslations);

                $latestEventPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [Events::class])->published()->exists()){
                    $latestEventPublishedDate = Content::whereHasMorph('contentable', [Events::class])->published()->orderBy('published_at')->first()->published_at;
                }

                $eventsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'events',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'events',
                    'lang' => 'en'
                ]), $latestEventPublishedDate, '1.0', 'daily', [], null, $eventsPageTranslations);

                $latestSpeechPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [Speech::class])->published()->exists()){
                    $latestSpeechPublishedDate = Content::whereHasMorph('contentable', [Speech::class])->published()->orderBy('published_at')->first()->published_at;
                }

                $speechesPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('content-index-page', [
                                'type' => 'speeches',
                                'lang' => 'am'
                            ]
                        )
                    ],
                ];
                $sitemap->add(route('content-index-page', [
                    'type' => 'speeches',
                    'lang' => 'en'
                ]), $latestSpeechPublishedDate, '1.0', 'daily', [], null, $speechesPageTranslations);

                $latestPhotoUploadedDate= Carbon::today();
                if(Photo::exists()){
                    $latestPhotoUploadedDate = Photo::orderBy('created_at')->first()->created_at;
                }

                $photoGalleryPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('photo-gallery', ['lang' => 'am'])
                    ],
                ];
                $sitemap->add(route('photo-gallery', [
                    'lang' => 'en'
                ]), $latestPhotoUploadedDate, '0.8', 'weekly', [], null, $photoGalleryPageTranslations);

                /**Others***/

                $latestFAQPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [Faq::class])->published()->exists()){
                    $latestFAQPublishedDate = Content::whereHasMorph('contentable', [Faq::class])->published()->orderBy('published_at')->first()->published_at;
                }

                $faqPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('faq-index', ['lang' => 'am'])
                    ],
                ];
                $sitemap->add(route('faq-index', [
                    'lang' => 'en'
                ]), $latestFAQPublishedDate, '0.8', 'weekly', [], null, $faqPageTranslations);

                $latestArchivalDate= Carbon::today();
                if(Content::archived()->exists()){
                    $latestArchivalDate = Content::archived()->orderBy('deleted_at')->first()->deleted_at;
                }
                $archivesPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('archive-index', ['lang' => 'am'])
                    ],
                ];
                $sitemap->add(route('archive-index', [
                    'lang' => 'en'
                ]), $latestArchivalDate, '0.8', 'weekly', [], null, $archivesPageTranslations);

                $contactUsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('contact-us-request-creation-page', ['lang' => 'am'])
                    ],
                ];
                $sitemap->add(route('contact-us-request-creation-page', [
                    'lang' => 'en'
                ]), Carbon::now(), '0.8', 'weekly', [], null, $contactUsPageTranslations);

                $latestPrivacyPolicyPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [PrivacyPolicy::class])->published()->exists()){
                    $latestPrivacyPolicyPublishedDate = Content::whereHasMorph('contentable', [PrivacyPolicy::class])->published()->orderBy('published_at')->first()->published_at;
                }
                $privacyPolicyPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('privacy-policy-detail', ['lang' => 'am'])
                    ],
                ];
                $sitemap->add(route('privacy-policy-detail', [
                    'lang' => 'en'
                ]), $latestPrivacyPolicyPublishedDate, '0.8', 'weekly', [], null, $privacyPolicyPageTranslations);

                $latestTermsAndConditionsPublishedDate= Carbon::today();
                if(Content::whereHasMorph('contentable', [TermAndCondition::class])->published()->exists()){
                    $latestTermsAndConditionsPublishedDate = Content::whereHasMorph('contentable', [TermAndCondition::class])->published()->orderBy('published_at')->first()->published_at;
                }
                $termsAndConditionsPageTranslations = [
                    [
                        'language' => 'am',
                        'url' => route('term-and-condition-detail', ['lang' => 'am'])
                    ],
                ];
                $sitemap->add(route('term-and-condition-detail', [
                    'lang' => 'en'
                ]), $latestTermsAndConditionsPublishedDate, '0.8', 'weekly', [], null, $termsAndConditionsPageTranslations);

            }

            // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
            return $sitemap->render('xml');
        } catch (\Throwable $ex) {
            logError($ex);
            if ($ex instanceof NotFound) {
                abort(404);
            }
            abort(503);
        }
    }
}

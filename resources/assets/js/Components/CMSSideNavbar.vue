<template>
    <aside class="cms-side-navbar" v-mobile-nav="hideOnClickOutside" v-show="!collapse">
        <ul class="navbar">
            <template v-for="(menu,index) in menus" :key="index">
                <template v-if="!menu.submenus || menu.submenus.length==0">
                    <li class="border-light-gray">
                        <inertia-link :href="menu.route" class="active:font-bold">
                            {{_trans('menu.'+menu.label)}}
                        </inertia-link>
                    </li>
                </template>
                <template v-else>
                    <li class="border-light-gray" :class="{'collapsed':menu.collapsed, 'expanded':!menu.collapsed}"
                        @click.stop.prevent="toggleDropdown(index)">
                        <a href="#" class="active:font-bold" @click.prevent>
                            <span class="inline-block flex-grow pr-5">
                            {{_trans('menu.'+menu.label)}}
                            </span>
                            <span class="flex-none w-max"><i class="fa fa-angle-down"></i>  </span>
                        </a>

                        <ul class="dropdown">
                            <li v-for="submenu of menu.submenus">
                                <inertia-link :href="submenu.route">
                                    <i class="far fa-circle text-yellow-500"></i>&nbsp;
                                    {{_trans('menu.'+submenu.label)}}
                                </inertia-link>
                            </li>
                        </ul>
                    </li>
                </template>
            </template>
        </ul>
    </aside>
</template>

<script>
    export default {
        name: "cms-side-navbar",
        emits: ['toggleCollapse'],
        props: {
            collapse: {
                type: Boolean,
                default: false
            },
            breakpoint: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                collapsed: this.collapse,
                menus: [
                    {
                        label: 'Users and Roles', route: '',
                        collapsed: true,
                        submenus: [
                            {label: 'Roles', route: route('roles.index')},
                            {label: 'Users', route: route('manage-accounts')},
                            {label: 'Role Permissions', route: route('role-permissions-page')},
                            {label: 'Audit Trails', route: route('audits-index')},
                        ]
                    },
                    {
                        label: 'Company', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'About Us', route: route('about-us-management-page')},
                            {
                                label: 'Organizational Structure',
                                route: route('organizational-structure-management-page')
                            },
                            {label: 'Profile', route: route('profile-management-page')},
                            {label: 'History', route: route('history-management-page')},
                            {label: 'Service Charter', route: route('service-charter-management-page')},
                            {label: 'Innovation', route: route('innovation-management-page')},
                            {label: 'CEO Message', route: route('ceo-message-management-page')},
                            {
                                label: 'Contact Us Requests',
                                route: route('contact-us-request-management-page')
                            },
                            {label: 'Contact Offices', route: route('contact-details-management-page')},
                        ]
                    },
                    {
                        label: 'Customer Service', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Post Paid', route: route('postpaid-management-page')},
                            {label: 'Pre Paid', route: route('prepaid-management-page')},
                            {label: 'Bill Information', route: route('bill-information-management-page')},
                            {label: 'Bill Complaint', route: route('bill-complaint-management-page')},
                            {
                                label: 'Customer Service Centers',
                                route: route('customer-service-center-management-page')
                            },
                            {label: 'Payments', route: route('payment-option-management-page')},
                            {label: 'Billings', route: route('billing-management-page')},
                            {
                                label: 'Getting Electricity',
                                route: route('getting-electricity-management-page')
                            },
                        ]
                    },
                    {
                        label: 'Public Information', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Tariffs', route: route('electricity-tariff-management-page')},
                            {
                                label: 'Power Interruptions',
                                route: route('power-interruption-management-page')
                            },
                            {
                                label: 'Customer Rights/Duties',
                                route: route('customer-right-and-duty-management-page')
                            },
                            {
                                label: 'Complaint Handling',
                                route: route('complaint-handling-management-page')
                            },
                            {label: 'Electrical Tips', route: route('electrical-tip-management-page')},
                            {label: 'Ease of Doing Business', route: route('ease-of-doing-business-management-page')},
                            {label: 'Projects/Programs', route: route('project-and-program-management-page')},
                            {
                                label: 'Corporate Social Responsibility',
                                route: route('social-responsibility-management-page')
                            },
                            {
                                label: 'Citizen Engagements',
                                route: route('citizen-engagement-management-page')
                            },

                        ]
                    },
                    {
                        label: 'Announcements', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Vacancies', route: route('vacancy-management-page')},
                            {label: 'Tenders', route: route('tender-management-page')},
                            {
                                label: 'Customer Announcements',
                                route: route('customer-announcement-management-page')
                            },
                            {
                                label: 'Staff Announcements',
                                route: route('staff-announcement-management-page')
                            }
                        ]
                    },
                    {
                        label: 'Media Center', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'News', route: route('news-management-page')},
                            {label: 'Events', route: route('events-management-page')},
                            {label: 'Press Releases', route: route('press-release-management-page')},
                            {label: 'Speeches', route: route('speech-management-page')},
                            {label: 'Photo Gallery', route: route('manage-photo-gallery')},
                        ]
                    },
                    {
                        label: 'Documents', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Documents', route: route('document-management-page')},
                        ]
                    },
                    {
                        label: 'Publications', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Publications', route: route('publication-management-page')},
                        ]
                    },

                    {
                        label: 'Other Contents', route: route('home'),
                        collapsed: true,
                        submenus: [
                            {label: 'Partners', route: route('partner-management-page')},
                            {label: 'FAQs', route: route('faq-management-page')},
                            {label: 'Main Sliders', route: route('main-slider-management-page')},
                            {label: 'Important Links', route: route('important-link-management-page')},
                            {label: 'Popup Contents', route: route('popup-content-management-page')},
                        ]
                    },
                    {
                        label: 'Policy and Terms', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Privacy Policy', route: route('privacy-policy-management-page')},
                            {label: 'Terms and Conditions', route: route('term-and-condition-management-page')},
                        ]
                    },

                    {
                        label: 'Settings', route: route("home"),
                        collapsed: true,
                        submenus: [
                            {label: 'Document Types', route: route('document-type-management-page')},
                            {label: 'Publication Types', route: route('publication-type-management-page')},
                            {label: 'Payment Types', route: route('payment-type-management-page')},
                            {label: 'Service Types', route: route('service-type-management-page')},
                            {label: 'FAQ Groups', route: route('faq-group-management-page')},
                            {label: 'Country', route: route('country-management-page')},
                            {label: 'Region', route: route('region-management-page')},
                            {label: 'Zone', route: route('zone-management-page')},
                            {label: 'City', route: route('city-management-page')},
                            {label: 'Subcity', route: route('subcity-management-page')},
                            {label: 'Woreda', route: route('woreda-management-page')},
                        ]
                    },

                ]
            }
        },

        methods: {
            toggleDropdown(index) {
                this.menus[index].collapsed = !this.menus[index].collapsed
            },

            hideOnClickOutside() {
                if (window.innerWidth < this.breakpoint.md) {
                    this.collapsed = true
                    this.$emit('toggleCollapse', this.collapsed)
                }
            },
        }
    }
</script>

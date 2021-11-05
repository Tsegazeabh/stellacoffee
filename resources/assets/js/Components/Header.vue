<template>
    <div class="header-nav" id="header-nav">
        <ul class="nav left">
            <li class="mr-4 font-bold text-yellow-600">
                <span
                    class="animate-ping bg-red-700 rounded-full absolute w-16 text-xs text-white flex justify-center left-12 top-5">
                 &nbsp;&nbsp;
                </span>
                <i class="fa fa-phone"></i>&nbsp;{{$page.props.free_call_center}}
            </li>
            <li class="mr-4"><i class="fa fa-envelope"></i>&nbsp;{{_trans('messages.Contact Email')}}</li>
            <li class="mr-4"><i class="fa fa-map-marker"></i>&nbsp;{{_trans('messages.Address')}}</li>

        </ul>

        <div class="nav right">
            <ul class="flex items-center justify-center flex-wrap">
                <li>
                    <button class="nav-link" @click.stop.prevent="toggleSearch">
                        <span><i class="fa fa-search"></i></span>
                    </button>
                </li>
                <li>
                    <a target="_blank" :href="$page.props.facebook_official_page" class="nav-link social-media-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a target="_blank" :href="$page.props.twitter_official_page" class="nav-link social-media-btn twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a target="_blank" :href="$page.props.telegram_official_page" class="nav-link social-media-btn telegram">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                </li>
                <li>
                    <a target="_blank" :href="$page.props.youtube_official_page" class="nav-link social-media-btn youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
                <li>
                    <inertia-link class="nav-link" type="button" :href="route('login')">
                        {{_trans('menu.Login')}}
                    </inertia-link>
                </li>
                <li>
                    <inertia-link class="nav-link" type="button" :href="route('news-management-page')">
                        {{_trans('menu.CMS')}}
                    </inertia-link>
                </li>
                <li>
                    <inertia-link class="nav-link" type="button" :href="route('faq-index')">
                        {{_trans('menu.FAQ')}}
                    </inertia-link>
                </li>
                <li class="nav-item dropdown">
                    <button title="Language">
                        <span>
<!--                            <i class="fa fa-language"></i>-->
                            {{_trans('locale.'+$page.props.locale)}}
                        </span>
                        <i class="fa fa-angle-down ml-1"></i>
                    </button>
                    <ul class="dropdown-menu hover-target">
                        <li class="dropdown-item py-0 w-full">
                            <button @click.stop="changeLanguage('en')"
                                    class="nav-link w-full p-0"
                                    :class="lang=='en'?'active':''">
                                English
                            </button>
                        </li>
                        <li class="dropdown-item py-0 w-full">
                            <button @click.stop="changeLanguage('am')"
                                    class="nav-link w-full p-0"
                                    :class="lang=='am'?'active':''">
                                አማርኛ
                            </button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="search-form-container" v-floating-search="hideSearchForm" v-show="!collapseSearch">
            <form class="search-form" @submit.prevent="search">
                <input v-model.lazy="searchForm.keyword" class="border-0 rounded px-3 focus:outline-none flex-grow"/>
                <button type="submit" class="text-green-600 flex-none w-max"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="main-navbar">
        <ul class="nav left">
            <nav class="brand-lg">
                <div class="container">
                    <div class="flex-none">
                        <div class="flex flex-col justify-start items-center w-max">
                            <a :href="route('home')">
                                <img :src="logo" class="h-16" alt="EEU"/>
                            </a>
                            <h1 class="org-name">
                                <a :href="route('home')" class="text-orange-500">እስቴላ ኮፊ</a>
                            </h1>
                            <h1 class="org-name">
                                <a :href="route('home')" class="eeu-color-green">Stella Coffee</a>
                            </h1>
                        </div>
                    </div>
                </div>
            </nav>
            <nav class="brand-sm">
                <div class="container">
                    <div class="flex flex-wrap justify-between">
                        <div class="flex flex-col justify-start items-center flex-none w-max">
                            <h1 class="org-name">
                                <a :href="route('home')">Ethiopian Electric Utility</a>
                            </h1>
                        </div>
                    </div>
                </div>
            </nav>
        </ul>

        <nav class="main-menu">
            <section id="menuToggle">
                <div class="button-container">
                    <div class="flex text-sm">
                        <button @click.stop.prevent="toggleCollapse">
                            <i class="fas fa-bars" v-show="collapse"></i>
                            <i class="fas fa-times" v-show="!collapse"></i> Menu
                        </button>

                        <button @click.stop.prevent="toggleSearch">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <!--                        <button><i class="fa fa-question-circle"></i> FAQ</button>-->
                        <!--                        <button title="Language">-->
                        <!--                            <i class="fa fa-language"></i> Language-->
                        <!--                        </button>-->
                    </div>
                </div>
            </section>

            <ul v-mobile-nav="hideOnClickOutside" v-show="!collapse">
                <li v-for="(menu,index) in menus" :key="index" class="nav-item"
                    :class="[{'dropdown': menu.submenus && menu.submenus.length>0}, {'hover-trigger':menu.submenus && menu.submenus.length},{'active':menu.active}, {'collapsed':menu.collapsed}]">
                    <template v-if="menu.submenus && menu.submenus.length>0">
                        <a href="#" @click.stop.prevent="toggleDropdown(index)">
                            <span>{{_trans('menu.'+menu.label)}}</span>
                            <i class="fas fa-caret-down pl-2"></i>
                        </a>

                        <ul class="dropdown-menu hover-target">
                            <li v-for="submenu of menu.submenus" class="dropdown-item">
                                <inertia-link :href="submenu.route" class="nav-link w-full">
                                    {{_trans('menu.'+submenu.label)}}
                                </inertia-link>
                            </li>
                        </ul>
                    </template>
                    <template v-else>
                        <inertia-link :href="menu.route" class="nav-link" @click.prevent="toggleDropdown(index)">
                            {{_trans('menu.'+menu.label)}}
                        </inertia-link>
                    </template>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import Button from "@components/Button";
    import logo from "../../images/logo.jpg"
    import {useForm} from '@inertiajs/inertia-vue3'

    import {getMenus} from "@shared/Menu"

    export default {
        name: "nav-header",
        components: {Button},
        props: {
            canLogin: Boolean,
            canRegister: Boolean
        },
        computed: {
            lang() {
                return this.$page.props.locale;
            }
        },
        data() {
            return {
                logo: logo,
                collapse: false,
                collapseSearch: true,
                breakpoint: {
                    sm: 640, md: 768, lg: 1024, xl: 1280, _2xl: 1536
                },
                menus: [],

                searchForm: useForm({
                    'keyword': ''
                })
            }
        },
        methods: {

            toggleCollapse() {
                if (window.innerWidth < this.breakpoint.md) {
                    this.collapse = !this.collapse
                    this.collapseSearch = true
                } else {
                    this.collapse = true;
                }
            },

            toggleSearch() {
                this.collapseSearch = !this.collapseSearch
                if (window.innerWidth < this.breakpoint.md) {
                    this.collapse = true
                }
            },

            toggleDropdown(index) {
                this.menus[index].collapsed = !this.menus[index].collapsed
            },

            hideOnClickOutside() {
                if (window.innerWidth < this.breakpoint.md) {
                    this.collapse = true
                }
            },

            hideSearchForm() {
                this.collapseSearch = true
            },

            search() {
                this.searchForm.submit("get", this.route('search'));
            }
        },
        async mounted() {
            this.lang = this.$page.props.locale
            this.menus = await getMenus()
            this.collapse = window.innerWidth < this.breakpoint.md
            window.addEventListener('resize', () => {
                this.collapse = window.innerWidth < this.breakpoint.md
            });
        }
    }
</script>

<style scoped>
    .bg-orange-500 {
        background-color: #FEA348;
    }

    .text-orange-500 {
        color: #FEA348;
    }

    .text-green-500 {
        color: #62C46F;
    }

    #menuToggle span {
        display: block;
        width: 33px;
        height: 4px;
        margin-bottom: 5px;
        position: relative;
        background: rgba(4, 120, 87);
        border-radius: 3px;
    }

    .hover-trigger:hover > .hover-target {
        display: block;
    }

    .social-media-btn {
        @apply text-xl focus:outline-none transition duration-200 flex items-center justify-center;
    }

    .social-media-btn.facebook {
        @apply hover:text-blue-600;
    }

    .social-media-btn.twitter {
        @apply hover:text-blue-500;
    }

    .social-media-btn.youtube {
        @apply hover:text-red-500;
    }

    .social-media-btn.telegram {
        @apply hover:text-blue-400;
    }
    .eeu-color-green {
        color: #71B666;
    }
</style>

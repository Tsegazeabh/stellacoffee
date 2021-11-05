<template>
    <footer>
        <div class="back-to-top">
            <a href="#header-nav">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>

        <div class="footer-container" id="footer">
            <div>
                <nav>
                    <template v-for="(menu, index) in footerMenus">
                        <div class="nav-container" v-if="index!=0">
                            <h1 class="header text-green-dark font-black">
                                {{_trans('menu.'+menu.label)}}
                            </h1>
                            <ul class="p-0 ml-0">
                                <li class="p-0 ml-0" v-for="(submenu, index) in menu.submenus" :key="index">
                                    <inertia-link :href="submenu.route" class="has-text-black">
                                        {{_trans('menu.'+submenu.label)}}
                                    </inertia-link>
                                </li>
                            </ul>
                        </div>
                    </template>
                </nav>
            </div>
            <div class="flex flex-wrap md:justify-center items-center text-gray-600">
                <a :href="route('archive-index')" class="mx-4 my-2">
                    <i class="fa fa-archive"></i> {{_trans('label.shared.Archives')}}
                </a>
                <a :href="route('contact-us-request-creation-page')" class="mx-4 my-2">
                    <i class="far fa-address-book"></i> {{_trans('menu.Contact Us')}}
                </a>
                <span class="mx-4 my-2">
                    <i class="fa fa-phone"></i> {{$page.props.free_call_center}}
                </span>
                <span class="mx-4 my-2">
                    <i class="far fa-envelope"></i> info@eeu.gov.et
                </span>
                <a href="https://goo.gl/maps/sDwFcKnZgkJe85oD7" target="_blank" class="mx-4 my-2">
                    <i class="fa fa-map-marker"></i> {{_trans('messages.Address')}}
                </a>

                <div class="flex items-center mx-4 my-2">
                    <span> {{_trans('titles.Follow us on')}}:</span>
                    <a target="_blank" :href="$page.props.facebook_official_page" class="social-media-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a target="_blank" :href="$page.props.twitter_official_page" class="social-media-btn twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a target="_blank" :href="$page.props.telegram_official_page" class="social-media-btn telegram">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                    <a target="_blank" :href="$page.props.youtube_official_page" class="social-media-btn youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap align-baseline pt-5 h-12 w-full bg-gray-200 opacity-90 text-gray-700">
                <inertia-link class="text-center px-3 font-bold hover:underline"
                              :href="route('privacy-policy-detail')">
                    {{_trans('label.shared.Privacy Policy')}}
                </inertia-link>
                <inertia-link class="text-center px-3 font-bold hover:underline"
                              :href="route('term-and-condition-detail')">
                    {{_trans('label.shared.Terms and Conditions')}}
                </inertia-link>
                <span class="text-center px-3 font-bold">
                    {{_trans('titles.Copyright')}} &copy; {{year}} eeu.gov.et - {{_trans('titles.Ethiopian Electric Utility')}}
                </span>
            </div>
        </div>
    </footer>
</template>

<script>
    import logo from '../../images/logo.jpg'
    import Button from "@components/Button"
    import {getMenus} from "@shared/Menu"

    export default {
        name: "footer",
        components: {Button},
        data() {
            return {
                logo: logo,
                year: new Date().getFullYear(),
                footerMenus: []
            }
        },
        async mounted() {
            this.footerMenus = await getMenus()
        },

        methods: {
            goto(refName) {
                var element = this.$refs[refName];
                var top = element.offsetTop;

                window.scrollTo(0, top);
            }
        }
    }
</script>

<style scoped>
    .social-media-btn {
        @apply bg-green-100 text-xl mx-3 rounded-full w-10 h-10 focus:outline-none transition duration-200 flex items-center justify-center;
    }

    .social-media-btn.facebook {
        @apply text-blue-600 hover:bg-blue-600 hover:text-white;
    }

    .social-media-btn.twitter {
        @apply text-blue-500 hover:bg-blue-500 hover:text-white;
    }

    .social-media-btn.youtube {
        @apply text-red-500 hover:bg-red-500 hover:text-white;
    }

    .social-media-btn.telegram {
        @apply text-blue-400 hover:bg-blue-400 hover:text-white;
    }

    .text-green-500 {
        color: #62C46F;
    }

    .font-extrabold {
        font-weight: 800;
    }
</style>

<template>
    <footer>
        <ul class="left">
            <li>
                <a href="/" class="flex flex-wrap border w-32 my-3">
                    <img src="/images/stella_coffee_logo.jpg" class="object-contain"/>
                </a>
            </li>
            <li>
                <p>Hello! We are Cuppino Coffee Production, a company that is passionate about making and selling coffee
                    with a great flavor. Our team of dedicated coffee experts celebrates exceptional coffee brands and
                    roasters by providing our guests the unique opportunity to try coffee the highest quality.</p>
            </li>
        </ul>
        <nav>
            <template v-for="(menu, index) in menus">
                <div class="nav-container">
                    <h1 class="header text-green-dark font-black">
                        {{ menu.label }}
                    </h1>
                    <ul class="p-0 ml-0">
                        <li class="p-0 ml-0" v-for="(submenu, index) in menu.submenus" :key="index">
                            <inertia-link :href="submenu.url" class="has-text-black">
                                {{ submenu.label }}
                            </inertia-link>
                        </li>
                    </ul>
                </div>
            </template>
        </nav>

        <address>
            <h2 class="header">Contact Information</h2>
            <ul class="address">
                <li>
                    <p><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;&nbsp;Bole, Addis Ababa,
                        Ethiopia</p>
                </li>
                <li>
                    <p><span class="fas fa-calendar-week"></span>&nbsp;&nbsp;&nbsp;&nbsp;Monday - Saturday </p>
                </li>
                <li>
                    <p><span class="fas fa-phone-alt"></span>&nbsp;&nbsp;&nbsp;&nbsp;(+251) 11 545 8901 / 545
                        7989</p>
                </li>
                <li>
                    <p><span class="fas fa-envelope"></span>&nbsp;&nbsp;&nbsp;&nbsp;info@stellacoffee.com</p>
                </li>
            </ul>
            <ul class="social-media-icons-list">
                <li>
                    <a :href="$page.props.facebook_official_page" target="_blank"><span class="fab fa-facebook-f" aria-hidden="true"></span></a>
                </li>
                <li>
                    <a :href="$page.props.twitter_official_page" target="_blank"><span class="fab fa-twitter" aria-hidden="true"></span></a>
                </li>
                <li>
                    <a :href="$page.props.linkedin_official_page" target="_blank"><span class="fab fa-linkedin" aria-hidden="true"></span></a>
                </li>
                <li>
                    <a :href="$page.props.instagram_official_page" target="_blank"><span class="fab fa-instagram" aria-hidden="true"></span></a>
                </li>
                <li>
                    <a :href="$page.props.youtube_official_page" target="_blank"><span class="fab fa-youtube" aria-hidden="true"></span></a>
                </li>
                <li>
                    <a :href="$page.props.telegram_official_page" target="_blank"><span class="fab fa-telegram" aria-hidden="true"></span></a>
                </li>
            </ul>
        </address>
        <div class="w-full flex flex-wrap border-t mt-5 pt-5">
            <a :href="route('privacy-policy-detail')" class="mx-3">Privacy policy</a>
            <a :href="route('term-and-condition-detail')" class="mx-3">Terms of use</a>
            <a :href="route('contact-us-request-creation-page')" class="mx-3">Contact us</a>
            <inertia-link :href="route('testimonials')"  class="mx-3">Testimonials</inertia-link>
            <a href="#" class="mx-3">FAQ</a>
            <a href="#" class="mx-3">Archive</a>
            <span><i class="fa fa-copyright"></i> {{year}} - {{_trans('titles.Stella Coffee')}}</span>
        </div>
    </footer>
</template>

<script>
import {getMenus} from "../Shared/Menu";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "site-footer",
    data() {
        return {
            menus: getMenus(),
            year: new Date().getFullYear(),
        }
    }
})
</script>

<style scoped>

</style>

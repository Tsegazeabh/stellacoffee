<template>
    <inertia-head title="Stella Coffee"></inertia-head>
    <top-header></top-header>
    <header-nav class="content-layout-menu"></header-nav>
    <main class="main-wrapper">
        <div class="flex flex-wrap leading-relaxed content-detail mx-4 md:mx-12">
            <div class="w-full md:w-3/4 md:pr-12">
                <slot>
                    <h1>Contents/ Detail</h1>
                </slot>
                <social-media-sharing-buttons></social-media-sharing-buttons>
            </div>
            <div class="w-full md:w-1/4">
                <most-popular-contents></most-popular-contents>
<!--                <div class="flex flex-col mb-3 pb-5">-->
<!--                    <h1 class="header1 mb-0 has-tooltip">-->
<!--                        <span-->
<!--                            class='tooltip rounded shadow-md p-1 bg-gray-100 text-blue-500 -mt-8'>{{ _trans('label.shared.Click For More Vacancies') }}</span>-->
<!--                        <inertia-link :href="route('latest-vacancy')">-->
<!--                            {{ _trans('titles.Vacancies') }}-->
<!--                        </inertia-link>-->
<!--                    </h1>-->
<!--                    <ul v-if="Vacancies && Vacancies.length > 0">-->
<!--                        <li>-->
<!--                            <inertia-link v-for="(vac,index) of Vacancies" :key="vac.id" :href="vac.url"-->
<!--                                          class="text-gray-600 flex ml-3 py-3 hover:text-black"-->
<!--                                          :class="(index!=Vacancies.length-1)?'border-b border-gray-100':''">-->
<!--                                <span>&raquo;</span><span class="pl-2">{{ vac.contentable.title }}</span>-->
<!--                            </inertia-link>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <ul v-else>-->
<!--                        <li>{{ _trans('label.shared.The are no open vacancies published yet') }}</li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="flex flex-col mb-3 pb-5">-->
<!--                    <h1 class="header1 mb-0 has-tooltip">-->
<!--                        <span-->
<!--                            class='tooltip rounded shadow-md p-1 bg-gray-100 text-blue-500 -mt-8'>{{ _trans('label.shared.Click For More Bids') }}</span>-->
<!--                        <inertia-link :href="route('latest-tender')">-->
<!--                            {{ _trans('titles.Tenders') }}-->
<!--                        </inertia-link>-->
<!--                    </h1>-->
<!--                    <ul v-if="Tenders && Tenders.length > 0">-->
<!--                        <li>-->
<!--                            <inertia-link v-for="(tend,index) of Tenders" :key="tend.id" :href="tend.url"-->
<!--                                          class="text-gray-600 flex ml-3 py-3 hover:text-black"-->
<!--                                          :class="(index!=Tenders.length-1)?'border-b border-gray-100':''">-->
<!--                                <span>&raquo;</span><span class="pl-2">{{ tend.contentable.title }}</span>-->
<!--                            </inertia-link>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                    <ul v-else>-->
<!--                        <li>{{ _trans('label.shared.The are no open tenders floated yet') }}</li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="flex flex-col mb-3 pb-5">-->
<!--                    <h1 class="header1 mb-0 has-tooltip">-->
<!--                        <span-->
<!--                            class='tooltip rounded shadow-md p-1 bg-gray-100 text-blue-500 -mt-8'>{{ _trans('label.shared.Click For More Links') }}</span>-->
<!--                        <inertia-link :href="route('get-important-links')">-->
<!--                            {{ _trans('titles.Important Links') }}-->
<!--                        </inertia-link>-->
<!--                    </h1>-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <inertia-link :href="route('archive-index')"-->
<!--                                          class="text-gray-600 flex ml-3 py-3 hover:text-black">-->
<!--                                <span>&raquo;</span><span class="pl-2">{{ _trans('label.shared.Archives') }}</span>-->
<!--                            </inertia-link>-->
<!--                        </li>-->
<!--                        <li v-if="importantLinks">-->
<!--                            <a v-for="(content,index) of importantLinks" :key="content.id"-->
<!--                               :href="content.contentable.link"-->
<!--                               class="text-gray-600 flex ml-3 py-3 hover:text-black"-->
<!--                               :class="(index!=importantLinks.length-1)?'border-b border-gray-100':''" target="_blank">-->
<!--                                <span>&raquo;</span><span class="pl-2">{{ content.contentable.title }}</span>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="flex flex-col mb-3 pb-5">
                    <div
                        class="flex flex-col w-max justify-center items-center border ml-3 px-5 py-2 border-yellow-500 rounded p-3 rounded-md">
                                <span class="flex flex-row flex-wrap w-full justify-start items-center">
                                    <span class="fa fa-phone-alt p-2 bg-yellow-600 text-white rounded-full"></span>
                                    <span
                                        class="text-green-500 font-black text-xl">&nbsp;{{ $page.props.free_call_center }}</span>
                                </span>
                        <span class="flex flex-wrap w-full mt-3 text-orange font-black text-base">{{ _trans('label.shared.Call Us')}}</span>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <site-footer></site-footer>
        </footer>
    </main>
</template>

<script>
import TopHeader from "@components/TopHeader";
import HeaderNav from "@components/HeaderNav";
import SiteFooter from "@components/SiteFooter";
import MostPopularContents from "@components/MostPopularContents";
import axios from "axios"
import SocialMediaSharingButtons from "@components/social-media/SocialMediaSharingButtons";
import {defineComponent} from "vue";

export default defineComponent({
    name: "contents-layout",
    components: {
        'social-media-sharing-buttons': SocialMediaSharingButtons,
        'site-footer': SiteFooter,
        'top-header':TopHeader,
        'header-nav':HeaderNav,
        'most-popular-contents': MostPopularContents
    },
});
</script>

<style scoped>
.main-wrapper {
    @apply m-4 md:m-0 md:pt-12;
}

.tooltip {
    @apply invisible absolute;
}

.has-tooltip:hover .tooltip {
    @apply visible z-50
}
</style>

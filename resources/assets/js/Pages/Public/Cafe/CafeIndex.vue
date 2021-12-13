<template>
    <teleport to="head" v-if="result && result.total>0">
        <title> {{result.data[0].contentable.title}} </title>
        <meta property="og:site_name" content="Stella Coffee">
        <meta property="og:title" content="Stella Coffee Website">
        <meta property="og:description" :content="result.data[0].contentable.lead_paragraph">
        <meta property="og:image" :content="result.data[0].contentable.first_image['src']">
        <meta property="og:url" :content="result.data[0].url">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@EEU_Officials">
        <meta name="twitter:creator" content="@EEU_Officials"/>
        <meta name="twitter:title" content="Ethiopian Electric Utility Portal">
        <meta name="twitter:description" :content="result.data[0].contentable.detail">
        <meta name="twitter:image" :content="result.data[0].contentable.first_image['src']">
        <meta property="twitter:url" :content="result.data[0].url">
    </teleport>
    <inertia-head title="Stella Coffee | Packages"></inertia-head>

    <div class="w-full">
        <div v-if="result && result.total>0" class="flex flex-wrap">
            <div v-for="(cafe_service,index) in result.data" class="card-container flex flex-col md:flex-row w-full">
                <div class="grid grid-cols-3 justify-center items-center border-b my-4 pb-5">
                    <div class="col-span-1">
                        <inertia-link v-if="cafe_service.contentable.first_media" :href="cafe_service.url">
                            <img :src="cafe_service.contentable.first_media.base64svg" :srcset="cafe_service.contentable.src_sets" class="object-fill"/>
                        </inertia-link>
                        <inertia-link v-else :href="cafe_service.url">
                            <img :src="cafe_service.contentable.first_image['src']" class="object-fill"/>
                        </inertia-link>
                        <p class="text-center font-bold">{{_trans('label.shared.Size')}}: {{cafe_service.contentable.size}} </p>
                        <p class="text-center font-bold">{{_trans('label.shared.Price')}}: {{cafe_service.contentable.price}}</p>
                    </div>
                    <div class="col-span-2 px-10 flex flex-col justify-center items-start">
                        <h2 class="text-stella text-xl my-3">
                            <inertia-link :href="cafe_service.url">
                                {{cafe_service.contentable.title}}
                            </inertia-link>
                        </h2>
                        <p class="text-justify">{{ cafe_service.contentable.lead_paragraph }}</p>
                        <div class="px-4 justify-center">
                            <template v-if="cafe_service.contentable.video_link">
                                <video-embed :src="cafe_service.contentable.video_link"></video-embed>
                            </template>
                            <p class="text-stella text-lg my-3 font-bold text-right bottom-0 right-0"><a :href="cafe_service.contentable.video_link" target="_blank">{{_trans('label.shared.Video Link')}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-4">
                <content-index-pagination :links="result.links"></content-index-pagination>
            </div>
        </div>
        <div class="pt-20" v-else>
            <h1 class="text-red-500 text-3xl text-center">
                {{_trans('messages.There is no published content yet')}}
            </h1>
        </div>
    </div>
</template>

<script>
import ContentsLayout2 from "@layouts/ContentsLayout2";
import moment from 'moment';
import {defineComponent} from 'vue';
import ContentIndexPagination from "@components/ContentIndexPagination";
import Embed from 'v-video-embed';
// import Vue from 'vue';
// Vue.use(Embed);

export default defineComponent({
    name: "cafe-index",
    components: {ContentIndexPagination,Embed},
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout
    props: {
        result: {
            type: Object,
            required: true
        },
        menu_name:String,
        sub_menu_name:String,
        action_name:String
    },

    data() {
        return {
            // result: [
            //     {
            //         name: 'Lavazza Crema e Gusto',
            //         image: 'images/stella_coffee_logo.jpg',
            //         description: 'Lavazza Crema e Gusto Espresso is a special blend of Robusta and Arabica beans.',
            //         price: '$14.00'
            //     },
            //     {
            //         name: 'Maxwell House Original Roast Ground Coffee',
            //         image: 'images/stella_coffee_logo.jpg',
            //         description: 'Ground Coffee Having a very interesting history, this coffee is easily recognized all over the globe.',
            //         price: '$14.00'
            //     },
            //     {
            //         name: 'Douwe Egberts Filter Blend Ground Coffee Medium Roast',
            //         image: 'images/stella_coffee_logo.jpg',
            //         description: 'Douwe Egberts Real Coffee is a blend of the world’s finest quality beans.',
            //         price: '$14.00'
            //     },
            //
            // ]
        }
    },

    methods: {
        formatDate(date) {
            return moment(String(date)).format('MMM DD, YYYY')
        },
    }
})
</script>

<style scoped>

.card-container .history-card .detail {
    @apply flex flex-col w-full flex-wrap shadow-md border px-8 py-4;
}

.card-container .header {
    @apply w-full flex text-center justify-start items-start;
}


@media (min-width: 768px) {

    .card-container:nth-child(2n+1) {
        @apply flex-row-reverse;
    }

    .card-container .history-card .detail {
        @apply mx-8;
    }

    .card-container:nth-child(2n) .history-card .detail {
        @apply rounded-tr-3xl rounded-bl-3xl;
    }

    .card-container:nth-child(2n+1) .history-card .detail {
        @apply rounded-tl-3xl rounded-br-3xl;
    }

    .card-container .header {
        @apply w-1/2;
    }

    .card-container .header .title {
        @apply h-16;
    }

    .card-container:nth-child(2n) .header {
        @apply flex-row-reverse border-r-4 border-gray-700;
    }

    .card-container:nth-child(2n+1) .header {
        @apply flex border-l-4 border-gray-700 items-start mr-1;
    }

    .card-container:last-child .header {
        @apply border-0;
    }

    .card-container:nth-child(2n) .header .circle {
        @apply -mr-6;
    }

    .card-container:nth-child(2n+1) .header .circle {
        @apply -ml-6;
    }

    .card-container .header .circle {
        @apply w-12 h-12 border-4 border-gray-700 bg-white rounded-full text-gray-700 left-1/3 -mt-3;
    }
}


</style>

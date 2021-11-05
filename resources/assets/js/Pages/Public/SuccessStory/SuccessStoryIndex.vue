<template>
    <div class="w-full">
        <div class="flex flex-wrap">
            <div class="flex flex-wrap justify-center items-center w-full pt-5 pb-16">
                <h1 class="text-center uppercase font-black text-2xl w-full md:w-1/2 mb-5">
                    {{_trans('label.shared.Brief Historical Review Of Stella Coffee')}}
                </h1>
                <img class="w-full md:w-1/2 object-fit" :src="EEU_HISTORY_PHOTO"/>
            </div>
            <div v-for="content in history" class="card-container flex flex-col md:flex-row w-full" v-if="history">
                <teleport to="head">
                    <title> {{content.contentable.title}} </title>
                    <meta property="og:site_name" content="Ethiopian Electric Utility">
                    <meta property="og:title" content="Ethiopian Electric Utility Portal">
                    <meta property="og:description" :content="content.contentable.cms_lead_paragraph">
                    <meta property="og:image" :content="content.contentable.first_image['src']">
                    <meta property="og:url" :content="content.url">

                    <!-- Twitter -->
                    <meta name="twitter:card" content="summary">
                    <meta name="twitter:site" content="@EEU_Officials">
                    <meta name="twitter:creator" content="@EEU_Officials"/>
                    <meta name="twitter:title" content="Ethiopian Electric Utility Portal">
                    <meta name="twitter:description" :content="content.contentable.detail">
                    <meta name="twitter:image" :content="content.contentable.first_image['src']">
                    <meta property="twitter:url" :content="content.url">
                </teleport>
                <div class="header">
                    <span class="circle hidden md:flex md:flex-wrap md:items-center md:justify-center">
                        <i class="fas fa-book"></i>
                    </span>
                    <span class="text flex md:items-start md:px-8 text-xl font-black mb-4">
                        {{content.contentable.from_date}} - {{content.contentable.to_date}}
                    </span>
                </div>
                <div class="history-card w-full md:w-1/2">
                    <div class="flex flex-wrap mb-16">
                        <div class="detail">
                            <h1 class="font-black mb-4">{{content.contentable.title}}</h1>
                            <div>
                                {{content.contentable.lead_paragraph}}
                            </div>
                            <div class="flex flex-wrap w-full justify-end items-end">
                                <inertia-link :href="content.url" class="uppercase font-semibold p-2 rounded-sm hover:bg-green-100 hover:border-green-300">
                                    {{_trans('action.Read more')}} &raquo;
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full pt-20" v-else>
                <h1 class="text-red-500 text-3xl text-center">
                    {{_trans('messages.There are no published content yet')}}
                </h1>
            </div>
        </div>
    </div>
</template>

<script>
    import ContentsLayout from "@layouts/ContentsLayout";
    import moment from 'moment';
    import Logo from "../../../../images/logo.jpg";
    import EEU_HISTORY_PHOTO from "../../../../images/logo.jpg";
    import {defineComponent } from 'vue';

    export default defineComponent({
        name: "history-index",
        layout: (h, page) => h(ContentsLayout, [page]), // if you want to use different persistence layout
        props: {
            history: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                EEU_HISTORY_PHOTO: EEU_HISTORY_PHOTO
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

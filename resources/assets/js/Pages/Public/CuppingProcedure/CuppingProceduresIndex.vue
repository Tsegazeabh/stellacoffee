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
    <inertia-head title="Stella Coffee | Cupping Procedures"></inertia-head>

    <div class="w-full">
        <div v-if="result && result.total>0" class="flex flex-wrap">
            <div v-for="(procedure,index) in result.data" class="card-container flex flex-col md:flex-row w-full">
                <div class="grid grid-cols-3 justify-center items-stretch border-b my-4 pb-5">
                    <div class="col-span-1">
                        <img :src="procedure.contentable.first_image['src']" class="object-fill"/>
                    </div>
                    <inertia-link :href="procedure.url"
                                  class="col-span-2 px-10 flex flex-col justify-center items-start hover:bg-gray-200">
                        <h2 class="text-stella text-xl my-3">
                            {{ procedure.contentable.title }}
                        </h2>
                        <p class="text-justify">{{ procedure.contentable.lead_paragraph }}</p>
                    </inertia-link>
                </div>
            </div>
            <div class="m-4 w-full">
                <content-index-pagination :links="result.links"></content-index-pagination>
            </div>
        </div>
        <div class="pt-20" v-else>
            <h1 class="text-red-500 text-3xl text-center">
                {{ _trans('messages.There is no published content yet') }}
            </h1>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import ContentsLayout2 from "../../../Layouts/ContentsLayout2";
import ContentIndexPagination from "../../../Components/ContentIndexPagination";

export default defineComponent({
    name: "cupping-procedures-index",
    components: {ContentIndexPagination},
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout,
    props: {
        result: {
            type: Object,
            required: true,
            default: {}
        },
    },
    provide: {
        menu_name: 'Cupping',
        sub_menu_name: 'Cupping Procedures',
    },
})
</script>

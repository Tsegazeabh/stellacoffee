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
    <inertia-head title="Stella Coffee | Testimonials"></inertia-head>

    <div class="w-full">
        <div v-if="result && result.total>0" class="flex flex-wrap">

            <div v-for="(content,index) in result.data" class="card-container flex flex-col md:flex-row w-full my-4" :key="index">
                <inertia-link :href="content.url" class="flex flex-row w-full justify-start items-start border-b py-3 gap-3 hover:bg-gray-200">
                    <div class="flex w-14 h-14 rounded-full border justify-center items-center">
                        <i class="fa fa-user fa-2x text-stella"></i>
                    </div>
                    <div class="flex flex-row flex-wrap justify-start items-start px-3">
                        <div class="flex-col">
                            <h6 class="text-stella text-xl mb-3 font-bold text-xl">
                                {{ content.contentable.testimonial_name }}
                            </h6>
                            <div class="flex flex-row flex-wrap w-full font-bold my-3">
                                <div class="flex flex-wrap w-max pr-3">
                                    <strong>
                                        {{
                                            _trans('label.shared.Testimonial Organization')
                                        }}:
                                    </strong>&nbsp;
                                    <span>{{ content.contentable.testimonial_organization }}</span>
                                </div>
                                <div class="flex flex-wrap w-max pr-3">
                                    <strong>
                                        {{
                                            _trans('label.shared.Testimonial Position')
                                        }}:
                                    </strong>&nbsp;
                                    <span>{{ content.contentable.testimonial_position }}</span>
                                </div>
                                <div class="flex flex-wrap w-max pr-3">
                                    <strong>
                                        {{
                                            _trans('label.shared.Testimonial Date')
                                        }}:
                                    </strong>&nbsp;
                                    <span>{{ formatDate(content.contentable.testimonial_date) }}</span>
                                </div>
                            </div>
                            <p class="text-justify">
                                {{ content.contentable.lead_paragraph }}
                            </p>
                        </div>
                    </div>
                </inertia-link>
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
import moment from "moment";

export default defineComponent({
    name: "testimonials-index",
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

    setup(props) {
        const formatDate = (date) => {
            return moment(String(date)).format('MMM DD, YYYY');
        }

        return {formatDate};
    }
})
</script>

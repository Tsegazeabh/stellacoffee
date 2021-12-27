<template>
    <div class="w-full pb-6" v-if="content">
        <teleport to="head">
            <title> {{content.contentable.title}} </title>
            <meta property="og:site_name" content="Stella Coffee">
            <meta property="og:title" content="Stella Coffee Website">
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
        <div class="flex flex-row w-full justify-start items-start border-b py-5 gap-5">
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

                    <div class="text-justify" v-html="content.contentable.testimonial_message"></div>
                </div>
            </div>
        </div>
        <related-contents></related-contents>
    </div>
</template>

<script>
import {defineAsyncComponent, defineComponent, provide} from "vue";
import RelatedContentsLoadingState from '@components/RelatedContentsLoadingState'
import RelatedContentsLoadingError from '@components/RelatedContentsLoadingError';
import moment from "moment";
import ContentsLayout2 from "../../../Layouts/ContentsLayout2";

const RelatedContents = defineAsyncComponent({
    // The factory function
    loader: () => import(/*webpackChunkName: 'RelatedContents'*/ '@components/RelatedContents.vue'),
    // Delay before showing the loading component. Default: 200ms.
    delay: 200,
    // The error component will be displayed if a timeout is provided and exceeded. Default: Infinity.
    timeout: 3000,
    // Defining if component is suspensible. Default: true.
    suspensible: false,
    // A component to use if the load fails
    errorComponent: RelatedContentsLoadingError,
    // A component to use while the async component is loading
    loadingComponent: RelatedContentsLoadingState
});

export default defineComponent({
    name: "testimonial-detail",
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout,
    props: {
        content: {
            type: Object,
            required: true,
            default: {}
        }
    },
    components: {
        'related-contents': RelatedContents
    },
    setup(props) {
        provide('content_id', props.content.id)
        provide('tags', props.content && props.content.tags ? props.content.tags.map(tag => tag.id) : [])
    },
    methods: {
        formatDate(date) {
            return moment(String(date)).format('MMM DD, YYYY')
        },
    }
})
</script>


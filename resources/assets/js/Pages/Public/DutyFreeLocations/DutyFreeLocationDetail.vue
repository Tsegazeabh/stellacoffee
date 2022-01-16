<template>
    <div class="w-full pb-6" v-if="content">
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
        <inertia-head :title="'Stella Coffee | '+ content.contentable.title "></inertia-head>
        <h2 class="text-stella text-2xl font-black my-3">{{ content.contentable.title }}</h2>

        <div class="flex flex-col flex-wrap my-4">
            <span class="py-2"><strong>{{_trans('label.shared.Airport Name')}}:</strong>&nbsp;{{content.contentable.airport_name}}</span>
            <span><strong>{{_trans('label.shared.Duty Free Location Address')}}:</strong>&nbsp;{{content.contentable.shop_address}}</span>
        </div>
        <div v-html="content.contentable.detail"></div>
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
    name: "duty-free-location-detail",
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


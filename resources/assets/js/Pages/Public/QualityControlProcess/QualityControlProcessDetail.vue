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
        <div class="header1">{{ content.contentable.title }}</div>
        <div v-html="content.contentable.detail"></div>
        <template v-if="content.contentable.video_link">
            <youtube-player class="w-100 h-100"
                ref="youtube"
                :videoid="_youTubeGetID(content.contentable.video_link)"
                :loop="loop"
                @ended="onEnded"
                @paused="onPaused"
                @played="onPlayed"
                :autoplay="false">
            </youtube-player>
        </template>
        <div class="flex flex-wrap justify-end items-center content-info text-gray-600 text-base pt-3 mt-3 text-right">
            <div class="pr-2 font-bold">
                {{ _trans('label.shared.Published at') }}: {{ formatDate(content.published_at) }}
            </div>
            <div class="ml-6">
                <span class="font-bold pr-2">{{ _trans('label.shared.Readers') }}:</span>
                <span class="underline">{{ content.content_hits_count }}</span>
            </div>
        </div>
        <related-contents></related-contents>
    </div>
</template>

<script>
import {defineAsyncComponent, provide, defineComponent} from 'vue'
import moment from 'moment'
import RelatedContentsLoadingState from '@components/RelatedContentsLoadingState'
import RelatedContentsLoadingError from '@components/RelatedContentsLoadingError'
import ContentsLayout from "@layouts/ContentsLayout"
import Logo from "../../../../images/logo.jpg";
import {YoutubeVue3} from 'youtube-vue3';
// import Vue from 'vue';
// Vue.use(Embed);

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
    name: "quality-control-process-detail",
    layout: (h, page) => h(ContentsLayout, [page]), // if you want to use different persistence layout
    props: {
        content: {
            type: Object,
            required: true,
            default: {}
        }
    },
    setup(props) {
        provide('content_id', props.content.id)
        provide('tags', props.content && props.content.tags ? props.content.tags.map(tag => tag.id) : [])
    },
    components: {
        'related-contents': RelatedContents,
        'youtube-player': YoutubeVue3
    },

    methods: {
        formatDate(date) {
            return moment(String(date)).format('MMM DD, YYYY')
        },
    }
})
</script>

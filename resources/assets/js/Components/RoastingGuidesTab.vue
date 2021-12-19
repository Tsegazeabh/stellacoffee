<template>
    <index-header class="h2 justify-center text-center" :title="_trans('titles.Roasting Guides')"></index-header>
    <template v-if="roastingGuides.length>0">
        <div v-for="item in roastingGuides" class="px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
            <h3 class="text-2xl font-bold">
                {{item.contentable.title}}
            </h3>
            <p  class="text-xl summary flex-grow-1 text-justify">
                {{item.contentable.lead_paragraph}}
            </p>
            <template v-if="item.contentable.video_link">
                <youtube-player class="w-100 h-100"
                                ref="youtube"
                                :videoid="_youTubeGetID(item.contentable.video_link)"
                                :loop="loop"
                                @ended="onEnded"
                                @paused="onPaused"
                                @played="onPlayed"
                                :autoplay="false">
                </youtube-player>
            </template>
            <div class="text-right m-3">
                <inertia-link
                    :href="route('content-index-page', 'roasting-guide')"
                    type="button"
                    class="btn">
                    {{_trans('action.Read more')}} &raquo;
                </inertia-link>
            </div>
        </div>
    </template>
    <div v-else class="w-full pt-20">
        <p class="text-red-500 text-3xl text-center">
            {{_trans('messages.There is no published content yet')}}
        </p>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import IndexHeader from "./IndexHeader";
import axios from "axios";
import {YoutubeVue3} from 'youtube-vue3';

export default defineComponent({
    name: "roasting-guides-tab",
    components: {
        IndexHeader,
        'youtube-player':YoutubeVue3
    },
    data() {
        return {
            roastingGuides: [],
        }
    },
    created() {
        this.fetchRoastingGuide();
    },
    methods: {
        fetchRoastingGuide() {
            axios
                .get(route('latest-roasting-guide'))
                .then((res) => this.roastingGuides = res.data)
                .catch(err => this.roastingGuides = []);
        }
    }
})
</script>

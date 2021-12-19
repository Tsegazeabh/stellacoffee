<template>
    <index-header class="h2 justify-center text-center" :title="_trans('titles.Quality Control Process')"></index-header>
    <template v-if="qualityControlProcesses.length>0">
        <div v-for="item in qualityControlProcesses" class="px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
            <h3 class="text-2xl font-bold">
                {{item.contentable.title}}
            </h3>
            <p  class="text-xl summary flex-grow-1 text-justify">
                {{item.contentable.lead_paragraph}}
            </p>
            <div class="text-right m-3">
                <inertia-link
                    :href="route('content-index-page', 'quality-control-process')"
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

export default defineComponent({
    name: "quality-control-process-tab",
    components: {
        IndexHeader
    },
    data() {
        return {
            qualityControlProcesses: [],
        }
    },
    created() {
        this.fetchQualityControlProcess();
    },
    methods: {
        fetchQualityControlProcess() {
            axios
                .get(route('latest-quality-control-process'))
                .then((res) => this.qualityControlProcesses = res.data)
                .catch(err => this.qualityControlProcesses = []);
        }
    }
})
</script>

<template>
    <index-header class="h2 justify-center text-center" :title="_trans('titles.Quality Control Process')"></index-header>
    <div v-if="qualityControlProcesses.length>0" class="px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
        <p  class="text-xl summary flex-grow-1 text-justify">
            {{qualityControlProcesses[0].contentable.lead_paragraph}}
        </p>
        <div class="text-right m-3">
            <inertia-link
                :href="route('quality-control-process-detail', qualityControlProcesses[0].id)"
                type="button"
                class="btn">
                {{_trans('action.Read more')}} &raquo;
            </inertia-link>
        </div>
    </div>
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

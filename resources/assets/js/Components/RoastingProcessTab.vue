<template>
    <index-header class="h2 justify-center text-center" :title="_trans('titles.Roasting Process')"></index-header>
    <div v-if="roastingProcesses.length>0" class="px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
        <p  class="text-xl summary flex-grow-1 text-justify">
            {{roastingProcesses[0].contentable.lead_paragraph}}
        </p>
        <div class="text-right m-3">
            <inertia-link
                :href="route('roasting-process-detail', roastingProcesses[0].id)"
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
    name: "roasting-process-tab",
    components: {
        IndexHeader
    },
    data() {
        return {
            roastingProcesses: [],
        }
    },
    created() {
        this.fetchRoastingProcess();
    },
    methods: {
        fetchRoastingProcess() {
            axios
                .get(route('latest-roasting-process'))
                .then((res) => this.roastingProcesses = res.data)
                .catch(err => this.roastingProcesses = []);
        }
    }
})
</script>

<template>
    <index-header class="h2 justify-center text-center" :title="_trans('titles.Roasting Guides')"></index-header>
    <div v-if="roastingGuides.length>0" class="px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
        <p  class="text-xl summary flex-grow-1 text-justify">
            {{roastingGuides[0].contentable.lead_paragraph}}
        </p>
        <div class="text-right m-3">
            <inertia-link
                :href="route('roasting-guide-detail', roastingGuides[0].id)"
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
    name: "roasting-guides-tab",
    components: {
        IndexHeader
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
                .get(route('tab-roasting-guide'))
                .then((res) => this.roastingGuides = res.data)
                .catch(err => this.roastingGuides = []);
        }
    }
})
</script>

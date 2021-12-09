<template>
    <index-header class="h2 justify-center text-center" :title="_trans('titles.Roasting Machines')"></index-header>
    <div v-if="roastingMachines.length>0" class="px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
        <p class="text-xl summary flex-grow-1 text-justify">
            {{roastingMachines[0].contentable.lead_paragraph}}
        </p>
        <div class="text-right m-3">
            <inertia-link
                :href="route('roasting-machine-detail', roastingMachines[0].id)"
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
    name: "roasting-machines-tab",
    components: {
        IndexHeader
    },
    data() {
        return {
            roastingMachines: [],
        }
    },
    created() {
        this.fetchRoastingMachine();
    },
    methods: {
        fetchRoastingMachine() {
            axios
                .get(route('latest-roasting-machine'))
                .then((res) => this.roastingMachines = res.data)
                .catch(err => this.roastingMachines = []);
        }
    }
})
</script>

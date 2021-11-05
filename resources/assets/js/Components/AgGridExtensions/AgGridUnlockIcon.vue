<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" aria-label="Open" title="Open" @click="openRow">
        <i class="fa fa-lock" aria-hidden="true"></i>
        <span class="sr-only">Open</span>
    </button>
</template>

<script>
import Button from "@components/Button";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-unlock-icon",
    components: {Button},
    data() {
        return {}
    },

    mounted() {
    },

    methods: {
        openRow() {
            this.params.context.componentParent.openRow(this.params.value, this.$toast)
        }
    }
})
</script>



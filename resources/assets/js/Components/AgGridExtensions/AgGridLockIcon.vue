<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Close" aria-label="Close"
            @click="closeRow">
        <span class="sr-only">Close</span>
        <i class="fa fa-lock-open" aria-hidden="true"></i>
    </button>
</template>

<script>
import Button from "@components/Button";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-lock-icon",
    components: {Button},
    data() {
        return {}
    },

    mounted() {
    },

    methods: {
        closeRow() {
            this.params.context.componentParent.closeRow(this.params.value, this.$toast, this.$toast)
        }
    }
})
</script>



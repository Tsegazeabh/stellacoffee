<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Delete" @click="deleteRow">
        <i class="fa fa-trash"></i>
    </button>
</template>

<script>
import Button from "@components/Button";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-delete-icon",
    components: {Button},
    data() {
        return {}
    },

    mounted() {
    },

    methods: {
        deleteRow() {
            this.params.context.componentParent.forceDeleteRow(this.params.value, this.$toast)
        }
    }
})
</script>

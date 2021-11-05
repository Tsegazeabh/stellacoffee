<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Restore" aria-label="Restore" @click="restoreRow">
        <i class="fa fa-trash-restore"></i>
    </button>
</template>

<script>
    import Button from "@components/Button";
    export default {
        name: "ag-grid-retore-icon",
        components: {Button},
        data() { return {} },

        mounted() { },

        methods: {
            restoreRow() {
                this.params.context.componentParent.restoreRow(this.params.value)
            }
        }
    }
</script>



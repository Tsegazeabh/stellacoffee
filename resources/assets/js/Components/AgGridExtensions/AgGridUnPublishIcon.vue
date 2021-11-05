<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" aria-label="Un-publish" title="Un-publish" @click="unpublishRow">
        <i class="fa fa-unlink" aria-hidden="true"></i>
        <span class="sr-only">Un-publish</span>
    </button>
</template>

<script>
    import Button from "@components/Button";
    export default {
        name: "ag-grid-unpublish-icon",
        components: {Button},
        data() { return {} },

        mounted() { },

        methods: {
            unpublishRow() {
                this.params.context.componentParent.unPublishRow(this.params.value, this.$toast)
            }
        }
    }
</script>



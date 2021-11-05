<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Publish" aria-label="Publish" @click="publishRow">
        <span class="sr-only">Publish</span>
        <i class="fa fa-globe" aria-hidden="true"></i>
    </button>
</template>

<script>
    import Button from "@components/Button";
    export default {
        name: "ag-grid-publish-icon",
        components: {Button},
        data() { return {} },

        mounted() { },

        methods: {
            publishRow() {
                this.params.context.componentParent.publishRow(this.params.value, this.$toast, this.$toast)
            }
        }
    }
</script>



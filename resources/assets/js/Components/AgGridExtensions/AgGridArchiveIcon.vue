<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Archive" aria-label="Archive" @click="archiveRow">
        <i class="fa fa-archive"></i>
    </button>
</template>

<script>
    import Button from "@components/Button";
    export default {
        name: "ag-grid-archive-icon",
        components: {Button},
        data() { return {} },

        mounted() { },

        methods: {
            archiveRow() {
                this.params.context.componentParent.archiveRow(this.params.value, this.$toast)
            }
        }
    }
</script>

<template>
    <a :href="params.previewRoute" class="p-3.5 text-red-500 flex justify-center items-center"
       aria-label="Preview" title="Preview" target="_blank">
        <span class="sr-only">Preview</span>
        <i class="fa fa-eye" aria-hidden="true"></i>
    </a>
</template>

<script>
    export default {
        name: "ag-grid-preview-icon"
    }
</script>



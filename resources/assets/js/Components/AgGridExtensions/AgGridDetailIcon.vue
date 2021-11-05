<template>
    <a class="cms-mgmt-btn" aria-label="Detail" title="Detail" :href="params.detailRoute">
        <span class="sr-only">Detail</span>
        <i class="fa fa-th-list" aria-hidden="true"></i>
    </a>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-detail-icon"
})
</script>



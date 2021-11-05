<template>
    <button @click.prevent="viewDetail" class="cms-mgmt-btn" aria-label="Detail" title="Detail">
        <span class="sr-only">Detail</span>
        <i class="fa fa-th-list" aria-hidden="true"></i>
    </button>
</template>

<script>
import Button from "@components/Button";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-audit-detail-icon",
    components: {Button},
    methods: {
        viewDetail() {
            this.params.context.componentParent.viewDetail(this.params.value)
        }
    }
})
</script>


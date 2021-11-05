<template>
    <a :href="params.editRoute" class="p-3.5 text-red-500 flex justify-center items-center" title="Edit"
       v-if="params.editRoute">
        <i class="fa fa-edit"></i>
    </a>
    <button @click.prevent="editRow" class="p-3.5 text-red-500 flex justify-center items-center" title="Edit" v-else>
        <i class="fa fa-edit"></i>
    </button>
</template>

<script>
import Button from "@components/Button";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-edit-icon",
    components: {Button},
    methods: {
        editRow() {
            this.params.context.componentParent.editRow(this.params.value)
        }
    }
})
</script>



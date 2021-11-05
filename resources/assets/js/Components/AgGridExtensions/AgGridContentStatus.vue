<template>
    <span class="text-red-500 flex justify-center">
        <span v-if="published">
            <i class="fa fa-check"></i>
        </span>
        <span v-else>
            <i class="fa fa-times"></i>
        </span>
    </span>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ag-grid-content-status",

    computed: {
        published: function () {
            return this.params ? this.params.value : false;
        }
    },
})
</script>



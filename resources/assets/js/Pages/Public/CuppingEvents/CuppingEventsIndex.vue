<template>

</template>

<script>
import {defineComponent} from "vue";
import ContentsLayout2 from "../../../Layouts/ContentsLayout2";

export default defineComponent({
    name: "cupping-events-index",
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout,
    props: {
        contents: {
            type: Object,
            required: true,
            default: {}
        },
        // menu_name:'Cupping',
        // sub_menu_name:'Cupping Events',
    }
})
</script>

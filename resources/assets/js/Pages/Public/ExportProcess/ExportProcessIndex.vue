<template>

</template>

<script>
import {defineComponent} from "vue";
import ContentsLayout2 from "../../../Layouts/ContentsLayout2";

export default defineComponent({
    name: "export-process-index",
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout,
    props: {
        contents: {
            type: Object,
            required: true,
            default: {}
        },
    },
    provide: {
        menu_name:'Find Us',
        sub_menu_name:'Export Processes',
    },
})
</script>

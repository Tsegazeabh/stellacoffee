<template>

</template>

<script>
import {defineComponent} from "vue";
import ContentsLayout2 from "../../../Layouts/ContentsLayout2";

export default defineComponent({
    name: "factory-locations-index",
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout,
    props: {
        contents: {
            type: Object,
            required: true,
            default: {}
        },
        menu_name:'menu.Find Us',
        sub_menu_name:'menu.Factory Locations',
    }
})
</script>

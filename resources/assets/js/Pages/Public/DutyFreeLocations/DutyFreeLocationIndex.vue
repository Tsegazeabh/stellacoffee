<template>

</template>

<script>
import {defineComponent} from "vue";
import ContentsLayout2 from "@layouts/ContentsLayout2";

export default defineComponent({
    name: "duty-free-location-index",
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
        sub_menu_name:'Duty Free Locations',
    },
})
</script>

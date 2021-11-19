<template>

</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";

export default defineComponent({
    name: "partner-management",
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
})
</script>

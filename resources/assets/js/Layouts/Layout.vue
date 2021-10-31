<template>
    <top-header></top-header>
    <header-nav></header-nav>
    <main>
        <slot></slot>
    </main>
    <site-footer></site-footer>
</template>

<script>
import {defineComponent} from "vue";
import HeaderNav from "@components/HeaderNav.vue";
import SiteFooter from "../Components/SiteFooter";

export default defineComponent({
    name: "Layout",
    components: {
        SiteFooter,
        'header-nav': HeaderNav
    }
})
</script>

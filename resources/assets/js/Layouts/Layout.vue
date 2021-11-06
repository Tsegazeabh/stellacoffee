<template>
    <inertia-head title="Stella Coffee"></inertia-head>
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
import SiteFooter from "@components/SiteFooter.vue";
import TopHeader from "@components/TopHeader.vue";

export default defineComponent({
    name: "layout",
    components: {
        TopHeader,
        SiteFooter,
        'header-nav': HeaderNav
    }
})
</script>

<style scoped>
nav.main-navbar {
    @apply absolute z-50 bg-transparent;
}
nav.main-navbar ul.menu > li.dropdown .ul{
    @apply absolute top-24;
}
</style>

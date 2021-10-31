<template>
    <header-nav></header-nav>
    <main>
        <slot></slot>
    </main>
</template>

<script>
import {defineComponent} from "vue";
import HeaderNav from "@components/HeaderNav.vue";

export default defineComponent({
    name: "Layout",
    components: {
        'header-nav': HeaderNav
    }
})
</script>

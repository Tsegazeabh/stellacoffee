<template>
    <main-slider></main-slider>
    <story></story>
    <testimonials-slider />
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import MainSlider from "@components/MainSlider";
import Layout from "@layouts/Layout";
import Story from "@components/Story";
import TestimonialsSlider from "@components/TestimonialsSlider";

export default defineComponent({
    layout: (h, page) => h(Layout, [page]),
    components: {
        TestimonialsSlider,
        Story,
        MainSlider,
        Head,
        Link,
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
})
</script>

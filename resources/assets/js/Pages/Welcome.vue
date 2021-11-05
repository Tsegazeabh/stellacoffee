<template>
    <inertia-head title="Stella Coffee | Home"></inertia-head>
    <main-slider></main-slider>
    <story></story>
    <roasting-tabs></roasting-tabs>
    <products-tab></products-tab>
    <cupping-process></cupping-process>
    <testimonials-slider />
    <certifications></certifications>
    <partners></partners>
    <find-us></find-us>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import MainSlider from "@components/MainSlider";
import Layout from "@layouts/Layout";
import Story from "@components/Story";
import TestimonialsSlider from "@components/TestimonialsSlider";
import TopHeader from "../Components/TopHeader";
import RoastingTabs from "../Components/RoastingTabs";
import ProductsTab from "../Components/ProductsTab";
import CuppingProcess from "../Components/CuppingProcess";
import Certifications from "../Components/Certifications";
import Partners from "../Components/Partners";
import FindUs from "../Components/FindUs";

export default defineComponent({
    layout: (h, page) => h(Layout, [page]),
    components: {
        FindUs,
        Partners,
        Certifications,
        CuppingProcess,
        ProductsTab,
        RoastingTabs,
        TopHeader,
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

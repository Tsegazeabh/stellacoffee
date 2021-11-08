<template>
    <slot name="header">
        <cms-header :collapse="collapse"
                    :breakpoint="breakpoint"
                    @toggleCollapse="toggleCollapse($event)">
        </cms-header>
    </slot>
    <main class="leading-relaxed bg-white w-full">
        <div class="flex w-full flex-wrap justify-start">
            <cms-side-navbar :collapse="collapse"
                             :breakpoint="breakpoint"
                             @toggleCollapse="toggleCollapse($event)">

            </cms-side-navbar>
            <div class="cms-main flex flex-col px-12 py-8">
                <slot name="breadcrumb"></slot>
                <slot name="default"></slot>
            </div>
        </div>
    </main>
</template>

<script>
import {defineComponent} from "vue";
import CMSHeader from "@components/CMSHeader.vue";
import CMSSideNavbar from "@components/CMSSideNavbar.vue";

export default defineComponent({
    name: "cms-layout",
    components: {
        'cms-header': CMSHeader,
        'cms-side-navbar': CMSSideNavbar
    },
    data() {
        return {
            collapse: true,
            breakpoint: {
                sm: 640, md: 768, lg: 1024, xl: 1280, _2xl: 1536
            },
        }
    },
    mounted() {
        this.collapse = window.innerWidth < this.breakpoint.md
        window.addEventListener('resize', () => {
            this.collapse = window.innerWidth < this.breakpoint.md
        });
    },
    methods: {
        toggleCollapse(collapsed) {
            this.collapse = collapsed;
        }
    }
})
</script>

<style scoped>
body, html {
    height: 100%;
    background-color: white !important;
}
</style>

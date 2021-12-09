<template>
    <div class="slider-card w-full h-full">
        <div class="filter">&nbsp;</div>
        <div class="card-image">
            <img :src="content.first_media.base64svg" :srcset="content.srcset" class="object-cover h-full w-full"/>
        </div>
        <div class="card-text">
            <h2 class="title">{{ content.title }} </h2>
            <p class="pb-6">{{ content.description }}</p>
            <inertia-link :href="content.url">Learn more &raquo;</inertia-link>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "slider-card",
    props: {
        content: {
            type: Object,
            required: true
        }
    }
})
</script>
<style>
.filter {
    @apply absolute w-full h-full z-40 bg-roast-dark bg-opacity-30;
}
</style>

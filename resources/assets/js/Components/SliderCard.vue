<template>
    <div class="slider-card w-full h-full">
        <div class="filter">&nbsp;</div>
        <div class="card-image">
            <img :src="content.image" class="object-cover h-full w-full"/>
        </div>
        <div class="card-text">
            <h2 class="title">{{ content.title }}</h2>
            <p>{{ content.lead_paragraph }}</p>
            <button>Learn more &raquo;</button>
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
    @apply absolute w-full h-full z-50 bg-roast-dark bg-opacity-30;
}
</style>

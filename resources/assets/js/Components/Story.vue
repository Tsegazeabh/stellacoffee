<template>
    <div id="story"
         class="w-full sm:flex sm:flex-col sm:flex-wrap md:grid md:grid-cols-5 items-stretch justify-items-stretch">
        <div class="md:col-span-2 px-0 md:px-3">
            <img src="http://127.0.0.1:8000/images/Ampersand-38.jpg" class="object-contain w-full"/>
        </div>
        <div class="md:col-span-3 px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
            <h2 class="leading-header flex-grow-0">Who we are?</h2>
            <h2 class="main-header flex-grow-0">Rich Taste, Great Aroma</h2>
            <p class="summary flex-grow-1">
                Free Wi-Fi, sockets near tables, friendly barista and a cozy atmosphere will help you in
                your exciting work or evening relax..
            </p>
            <button class="flex-grow-0">Learn more &raquo;</button>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "story"
})
</script>

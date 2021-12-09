<template>
    <div id="story"
         class="w-full sm:flex sm:flex-col sm:flex-wrap md:grid md:grid-cols-5 items-stretch justify-items-stretch">
        <div class="md:col-span-2 px-0 md:px-3">
            <img src="http://127.0.0.1:8000/images/Ampersand-38.jpg" class="object-contain w-full"/>
        </div>
        <div class="md:col-span-3 px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
            <h2 class="leading-header flex-grow-0">Who we are?</h2>
            <h2 class="main-header flex-grow-0">Rich Taste, Great Aroma</h2>
            <p class="summary flex-grow-1 text-justify">
                “My day beginning with Stella Coffee exotic aroma is hilarious!”, Stella Coffee Owner.<br>
                Stella Coffee was established in 2021 by an experienced coffee business woman who have a deep-rooted attachment with the coffee industry as a heritage from her father.
                The owner of the Stella Coffee was born to a father who owned one of the best companies that had excelled in exporting and delivering the best Ethiopian coffee to the world.
                As a coffee star, Stella Coffee strives to shine in the Global Coffee Roasting Industry and deliver the best coffee with a naturally exotic aroma to its customers’
                satisfaction and this is its highest priority as a value that is never to be compromised.
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

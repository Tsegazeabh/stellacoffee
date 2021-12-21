<template>
    <div id="story" v-if="successStory"
         class="w-full sm:flex sm:flex-col sm:flex-wrap md:grid md:grid-cols-5 items-stretch justify-items-stretch">
        <div class="md:col-span-2 px-0 md:px-3">
            <img src="http://127.0.0.1:8000/images/Ampersand-38.jpg" class="object-contain w-full"/>
        </div>
        <div class="md:col-span-3 px-0 py-5 md:py-0 md:pl-3 flex flex-col flex-wrap items-start justify-between">
            <h2 class="leading-header flex-grow-0">Who we are?</h2>
            <h2 class="main-header flex-grow-0">
                {{ successStory.contentable.title }}
            </h2>
            <p class="summary flex-grow-1 text-justify">
                {{ successStory.contentable.lead_paragraph }}
            </p>
            <inertia-link :href="successStory.url" class="button flex-grow-0">Learn more &raquo;</inertia-link>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, onMounted} from 'vue'

export default defineComponent({
    name: "story",

    setup() {
        const successStory = ref(null)
        const fetchLatestSuccessStory = () => {
            axios.get(route('latest-success-story')).then(
                (res) => {
                    successStory.value = res.data;
                },
                (error) => {
                    if (error.response) {
                        console.error(error.response.data);
                        console.error(error.response.status);
                        console.error(error.response.headers);
                    } else {
                        console.error(error.message);
                    }
                });
        }

        onMounted(fetchLatestSuccessStory)

        return {
            successStory
        };
    }
})
</script>

<template>
    <div class="flex flex-col mb-5 pb-5" id="most-popular-contents-container">
        <h1 class="header1 py-3">{{ _trans('titles.Most Popular Contents') }}</h1>
        <template v-if="contents && contents.length >0">
            <inertia-link v-for="(content,index) of contents" :key="content.id" :href="content.url"
                          class="text-gray-600 flex ml-3 py-3 hover:text-black"
                          :class="(index!=contents.length-1)?'border-b border-gray-100':''">
                <span>&raquo;</span><span class="pl-2">{{ content.contentable.title }}</span>
            </inertia-link>
        </template>
        <div v-else>
            <p>{{ _trans('label.shared.The are no visited contents yet') }}</p>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue"
import axios from "axios"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "most-popular-contents",

    setup() {

        let contents = ref([]);

        const fetchMostPopularContents = async () => {
            let response = await axios.get(route('most-popular-contents', 5))
            contents.value = response.data
        }

        onMounted(fetchMostPopularContents)

        return {contents, fetchMostPopularContents}
    }
})
</script>

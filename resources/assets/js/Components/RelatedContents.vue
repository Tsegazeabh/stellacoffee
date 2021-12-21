<template>
    <div class="py-3 my-3" v-if="relatedContents && relatedContents.total>0">
        <h1 class="h1 text-2xl font-black py-3 text-roast-light border-b">{{ _trans('titles.Related Contents') }}</h1>
        <div class="justify-stretch items-stretch mt-6">
            <div class="card-container flex flex-col md:flex-row w-full" v-for="content in relatedContents.data"
                 :key="content.id">
                <div class="grid grid-cols-3 justify-center items-start border-b my-4 pb-5">
                    <div class="col-span-1">
                        <img :src="content.contentable.first_image['src']" class="object-fill"/>
                    </div>

                    <div class="col-span-2 px-10 flex flex-col justify-start items-start">
                        <h2 class="text-stella text-2xl my-3">
                            <inertia-link :href="content.url"> {{ content.contentable.title }}</inertia-link>
                        </h2>
                        <p class="text-justify">{{ content.contentable.lead_paragraph }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <json-result-paginator
                :links="relatedContents.links"
                @page-changed="changePage">
            </json-result-paginator>
        </div>
    </div>
</template>

<script>
import {inject, onMounted, ref, watch} from 'vue'
import axios from 'axios'
import Button from "@components/Button";
import JsonResultPaginator from "@components/JsonResultPaginator";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "related-contents",
    components: {JsonResultPaginator, Button},
    inject: ['content_id', 'tags'],

    setup() {

        const content_id = inject('content_id')
        const tags = inject('tags')
        let relatedContents = ref([])
        const currentPage = ref(0)

        const getRelatedContents = async () => {
            if (tags.length > 0) {
                let response = await axios.post(route('related-contents', content_id), {
                    'tags': tags,
                    'page': currentPage.value
                })
                relatedContents.value = response.data
            }
        }

        onMounted(getRelatedContents)

        watch(currentPage, getRelatedContents)

        const changePage = async (page) => {
            currentPage.value = page
        }

        return {relatedContents, changePage, getRelatedContents}
    },
})
</script>

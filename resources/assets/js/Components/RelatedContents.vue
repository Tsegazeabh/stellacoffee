<template>
    <div class="py-3 my-3" v-if="relatedContents && relatedContents.total>0">
        <h1 class="header1 p-3 border-b">{{_trans('titles.Related Contents')}}</h1>
        <div class="justify-stretch items-stretch mt-6">
            <div class="grid grid-cols-2 gap-6">
                <div class="w-full border p-3" v-for="content in relatedContents.data" :key="content.id">
                    <h2 class="header2">
                        <inertia-link class="underline" :href="content.url">
                            {{content.contentable.title}}
                        </inertia-link>
                    </h2>
                </div>
            </div>
            <div class="w-full">
                <json-result-paginator
                    :links="relatedContents.links"
                    @page-changed="changePage">
                </json-result-paginator>
            </div>
        </div>
    </div>
</template>

<script>
    import {inject, onMounted, ref, watch} from 'vue'
    import axios from 'axios'
    import Button from "@components/Button";
    import JsonResultPaginator from "@components/JsonResultPaginator";

    export default {
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
    }
</script>

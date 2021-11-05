<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1 justify-end">
            <template v-for="(link, k) in links" :key="k">
                <div v-if="link.url === null"
                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                     v-html="link.label"/>
                <button v-else
                        @click.prevent.stop="changePage(link.url)"
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                        :class="{ 'bg-blue-700 text-white': link.active }"
                        v-html="link.label"/>
            </template>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "json-result-paginator",
    props: {
        links: Array,
    },
    emits: ['pageChanged'],
    methods: {
        changePage(url) {
            let page = url.split('page=')[1];
            this.$emit('pageChanged', page)
        }
    }
})
</script>

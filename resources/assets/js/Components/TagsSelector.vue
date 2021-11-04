<template>
    <Multiselect
        v-model="model"
        :options="tags"
        track-by="name"
        :id="id"
        label="name"
        :searchable="true"
        :multiple="true"
        :taggable="true"
        :close-on-select="false"
        :placeholder="_trans('label.shared.Select Tags')"
        :tag-placeholder="_trans('label.shared.Add this as new tag')"
        @tag="addTag"
        ref="tagMultiSelect">
    </Multiselect>
</template>

<script>
    import {getAllTags, createNewTag} from "@shared/TagsService"
    import Multiselect from '@suadelabs/vue3-multiselect'

    export default {
        name: "tags-selector",

        props: {
            selectedTags: {
                type: Array,
                default: []
            }
        },

        data() {
            return {
                tags: [],
                contentTags: []
            }
        },

        components: {Multiselect},

        mounted() {
            this.fetchTags()
        },
        computed: {
            model: {
                set(value) {
                    this.$emit('input', value);
                },
            }
        },
        methods: {

            async fetchTags() {
                this.tags = await getAllTags();
                this.contentTags = this.tags.filter((t) => t.id == 57);
            },

            async addTag(tag) {
                tag = tag.trim();
                let selectedTag = this.tags.filter((t) => t.name.toLowerCase() === tag.toLowerCase())
                if (selectedTag == null || selectedTag.length == 0) {
                    this.tags = await createNewTag(tag)
                    selectedTag = this.tags.filter((t) => t.name.toLowerCase() === tag.toLowerCase())
                    this.contentTags.push(selectedTag)
                } else {
                    this.contentTags.push(selectedTag)
                }
            }
        }
    }
</script>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

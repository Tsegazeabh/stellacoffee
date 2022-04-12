<template>
    <div class="flex flex-wrap w-full">
        <div class="breadcrump">
            <ul>
                <li>
                    <inertia-link :href="route('home')">{{_trans('menu.Home')}}</inertia-link>
                </li>
                <li>
                    <inertia-link :href="route('dashboard')">{{_trans('menu.CMS')}}</inertia-link>
                </li>
                <li>{{_trans('label.shared.Region')}}</li>
            </ul>
        </div>
        <div class="flex flex-wrap w-full justify-end">
            <inertia-link type="button" :href="route('region-creation-page')"
                          class="border text-gray-500 px-4 py-2 uppercase text-sm">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;{{_trans('label.shared.Create Region')}}
            </inertia-link>
        </div>
        <form class="flex flex-wrap w-full py-8">
            <div class="form-group sm:w-full md:w-1/2 md:pr-6">
                <input type="text" v-model="form.simple_filters.search_keyword" class="form-control w-full"
                       :placeholder="_trans('label.shared.Search Keyword')"/>
            </div>
            <div class="form-group sm:my-4 md:my-0 sm:w-full md:w-1/2 flex flex-wrap justify-end items-center">
                <button type="submit" @click.prevent="search" class="search-btn flex-none w-max md:ml-6">{{_trans('action.Search')}}</button>
            </div>
        </form>
    </div>
    <table class="cms-table">
        <thead>
        <tr>
            <th class="text-left p-3">#</th>
            <th class="text-left p-3">Region(EN)</th>
            <th class="text-left p-3">ክልል(አማ)</th>
            <th class="text-left p-3">Région(Fr)</th>
            <th class="text-left p-3">Regione(IT)</th>
            <th class="text-left p-3">{{_trans('label.shared.Created At')}}</th>
            <th class="text-left p-3">{{_trans('label.shared.Created By')}}</th>
            <th class="text-left p-3" colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(content,index) in searchResult.data" :key="content.id">
            <td class="text-left px-3 py-1">{{(searchResult.current_page-1)*searchResult.per_page + index + 1}}</td>
            <td class="text-left px-3 py-1">{{content.name}}</td>
            <td class="text-left px-3 py-1">{{content.name_am}}</td>
            <td class="text-left px-3 py-1">{{content.name_fr}}</td>
            <td class="text-left px-3 py-1">{{content.name_it}}</td>
            <td class="text-left px-3 py-1">{{content ? formatDate(content.created_at):'N/A'}}</td>
            <td class="text-left px-3 py-1">{{content.created_by}}</td>
            <td class="text-right">
                <inertia-link type="button"
                              v-if="content && !content.trashed"
                              :href="route('region-editor-page', content.id)"
                              class="cms-mgmt-btn" aria-label="Edit" title="Edit">
                    <i class="fa fa-edit"></i>
                    <span class="sr-only">{{_trans('action.edit')}}</span>
                </inertia-link>
            </td>
            <td class="text-right">
                <button class="cms-mgmt-btn"
                        aria-label="Delete"
                        title="Delete"
                        @click.prevent="forceDelete(content.id)">
                    <i class="fa fa-trash"></i>
                    <span class="sr-only">{{_trans('action.delete')}}</span>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-if="searchResult.links.length > 3" class="my-2">
        <div class="flex flex-wrap -mb-1 justify-end">
            <template v-for="(link, k) in searchResult.links" :key="k">
                <div v-if="link.url === null"  class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
                <a v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-blue-700 text-white': link.active }" :href="link.url" v-html="link.label"></a>
            </template>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import AdminLayout from "@layouts/AdminLayout"
    import Button from "@components/Button"
    import {useForm} from '@inertiajs/inertia-vue3'
    import {Inertia} from "@inertiajs/inertia"
    import axios from "axios"

    export default {
        name: "manage-region",
        components: {Button},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,

        props: {
            errors: {type: Array, default: []},
            searchResult: {type: Object, default: {}},
            successMessage: {type: String, default: ''},
            errorMessage: {type: String, default: ''},
        },

        data() {
            return {
                form: useForm({
                    page: 1,
                    sorting_col: 'created_at',
                    sorting_dir: 'created_at',
                    simple_filters: {
                        search_keyword: '',
                    },
                    object_filters: {}
                })
            }
        },

        mounted() {
            this.form.page = this.searchResult.current_page;
            if (this.successMessage) {
                this.$toast.success(this.successMessage);
            } else if (this.errorMessage) {
                this.$toast.error(this.errorMessage);
            }
        },

        methods: {
            forceDelete($content_id) {
                if (confirm("Are you sure you want to delete the content?")) {
                    Inertia.delete(route('delete-region', $content_id), {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.$toast.success('Content is deleted successfully!');
                        },
                    });
                }
            },

            formatDate(date) {
                return moment(String(date)).format('MMM DD, YYYY')
            },

            gotoPage(page) {
                this.form.page = page;
                this.search();
            },

            search() {
                this.form.submit('post', route('search-region'));
            }
        }
    }
</script>

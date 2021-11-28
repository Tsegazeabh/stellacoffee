<template>
    <div class="w-full" v-if="content">
        <div class="header1">{{content.contentable.title}}</div>
        <div v-html="content.contentable.detail"></div>

        <div class="flex flex-wrap justify-end items-center content-info text-gray-600 text-base pt-3 mt-3 text-right">
            <div class="pr-2 font-bold">
                {{_trans('label.shared.Published at')}}: <span class="underline">{{formatDate(content.published_at)}}</span>
            </div>
            <div class="ml-6">
                <span class="font-bold pr-2">{{_trans('label.shared.Readers')}}:</span>
                <span class="underline">{{content.content_hits_count}}</span>
            </div>
        </div>
    </div>
    <div class="w-full pt-20" v-else>
        <h1 class="text-red-500 text-3xl text-center">
            {{_trans('messages.There are no published content yet')}}
        </h1>
    </div>
</template>

<script>
    import {defineAsyncComponent, provide} from 'vue'
    import moment from 'moment'
    import ContentsLayout from "@layouts/ContentsLayout"
    import Logo from "../../../../images/logo.jpg"

    export default {
        name: "privacy-policy-detail",
        layout: (h, page) => h(ContentsLayout, [page]), // if you want to use different persistence layout
        props: {
            content: {
                type: Object,
                required: true,
                default: {}
            }
        },
        setup(props) {
            if(props.content){
                provide('content_id', props.content.id)
            }
        },

        methods:{
            formatDate(date) {
                return moment(String(date)).format('MMM DD, YYYY')
            },
        }
    }
</script>

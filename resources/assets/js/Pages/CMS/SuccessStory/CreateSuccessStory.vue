<template>
    <div class="breadcrump">
        <ul>
            <li>
                <inertia-link :href="route('home')">{{ _trans('menu.Home') }}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('dashboard')">{{ _trans('menu.CMS') }}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('success-story-management-page')">
                    {{ _trans('label.shared.Success Story') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <SuccessStoryForm :success_story="success_story"
                      :error-message="errorMessage"
                      :success-message="successMessage"
                      :errors="errors"
                      :method="'post'"
                      :url="route('post-success-story')">
    </SuccessStoryForm>
</template>
<script>
import AdminLayout from "@layouts/AdminLayout"
import SuccessStoryForm from "@components/SuccessStoryForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateSuccessStory",
    components: {SuccessStoryForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        success_story: {
            type: Object,
            default: {
                title: '',
                detail: '',
                video_link: '',
                tags: [],
            }
        },
        errors: {type: Object, default: {}},
        errorMessage: {type: String, default: ''},
        successMessage: {type: String, default: ''}
    },
})
</script>

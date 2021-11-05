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
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <SuccessStoryForm :success_story="success_story"
                      :error-message="errorMessage"
                      :success-message="successMessage"
                      :errors="errors"
                      :method="'put'"
                      :url="route('edit-success-story', success_story.id)">
    </SuccessStoryForm>
</template>

<script>
import AdminLayout from "@layouts/AdminLayout";
import SuccessStoryForm from "@components/SuccessStoryForm";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "edit-success-story",
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    components: {
        SuccessStoryForm
    },
    props: {
        success_story: {
            type: Object,
            default: {
                title: '',
                detail: '',
                video_link: '',
                tags: [],
            },
            required: true
        },
        errors: {
            type: Object,
            default: {}
        },
        errorMessage: {
            type: String,
            default: ''
        },
        successMessage: {
            type: String,
            default: ''
        }
    }
})
</script>

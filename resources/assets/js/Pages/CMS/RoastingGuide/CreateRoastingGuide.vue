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
                <inertia-link :href="route('roasting-guide-management-page')">
                    {{ _trans('label.shared.Roasting Guide') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <RoastingGuideForm :roasting_guide="roasting_guide"
                       :error-message="errorMessage"
                       :success-message="successMessage"
                       :errors="errors"
                       :method="'post'"
                       :url="route('post-roasting-guide')">
    </RoastingGuideForm>
</template>
<script>
import AdminLayout from "@layouts/AdminLayout"
import RoastingGuideForm from "@components/RoastingGuideForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateRoastingGuide",
    components: {RoastingGuideForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        roasting_guide: {
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

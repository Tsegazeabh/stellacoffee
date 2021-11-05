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
                <inertia-link :href="route('quality-control-process-management-page')">
                    {{ _trans('label.shared.Quality Control Process') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <QualityControlProcessForm :quality_control_process="quality_control_process"
                               :error-message="errorMessage"
                               :success-message="successMessage"
                               :errors="errors"
                               :method="'post'"
                               :url="route('post-quality-control-process')">
    </QualityControlProcessForm>
</template>

<script>
import AdminLayout from "@layouts/AdminLayout"
import QualityControlProcessForm from "@components/QualityControlProcessForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateQualityControlProcess",
    components: {QualityControlProcessForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        quality_control_process: {
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

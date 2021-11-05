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
                <inertia-link :href="route('roasting-service-management-page')">
                    {{ _trans('label.shared.Roasting Service') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <RoastingServiceForm :roasting_service="roasting_service"
                         :error-message="errorMessage"
                         :success-message="successMessage"
                         :errors="errors"
                         :method="'put'"
                         :url="route('edit-roasting-service', roasting_service.id)">
    </RoastingServiceForm>
</template>

<script>
import AdminLayout from "@layouts/AdminLayout";
import RoastingServiceForm from "@components/RoastingServiceForm";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "edit-roasting-service",
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    components: {
        RoastingServiceForm
    },
    props: {
        roasting_service: {
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

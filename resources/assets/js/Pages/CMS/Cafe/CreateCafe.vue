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
                <inertia-link :href="route('cafe-management-page')">
                    {{ _trans('label.shared.Cafe Services') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <CafeForm :cafe="cafe"
                :error-message="errorMessage"
                :success-message="successMessage"
                :errors="errors"
                :method="'post'"
                :service_types="service_types"
                :url="route('post-cafe')">
    </CafeForm>
</template>
<script>
import AdminLayout from "@layouts/AdminLayout"
import CafeForm from "@components/CafeForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateCafe",
    components: {CafeForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        cafe: {
            type: Object,
            default: {
                title: '',
                service_type_id: '',
                size: '',
                price: '',
                attachments:'',
                detail: '',
                video_link: '',
                tags: [],
            },
        },
        service_types:{
            type: Object,
            required:true
        },
        errors: {type: Object, default: {}},
        errorMessage: {type: String, default: ''},
        successMessage: {type: String, default: ''}
    },
})
</script>

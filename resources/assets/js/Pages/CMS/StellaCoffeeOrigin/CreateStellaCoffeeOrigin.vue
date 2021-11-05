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
                <inertia-link :href="route('stella-coffee-origin-management-page')">
                    {{ _trans('label.shared.Stella Coffee Origin') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <StellaCoffeeOriginForm :stella_coffee_origin="stella_coffee_origin"
                            :error-message="errorMessage"
                            :success-message="successMessage"
                            :errors="errors"
                            :method="'post'"
                            :url="route('post-stella-coffee-origin')">
    </StellaCoffeeOriginForm>
</template>
<script>
import AdminLayout from "@layouts/AdminLayout"
import StellaCoffeeOriginForm from "@components/StellaCoffeeOriginForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateStellaCoffeeOrigin",
    components: {StellaCoffeeOriginForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        stella_coffee_origin: {
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

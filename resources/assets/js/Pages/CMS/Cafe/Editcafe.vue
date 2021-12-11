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
                    {{ _trans('label.shared.Cafe') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <CafeForm :cafe="cafe"
                        :error-message="errorMessage"
                        :success-message="successMessage"
                        :errors="errors"
                        :method="'put'"
                        :url="route('edit-cafe', cafe.id)">
    </CafeForm>
</template>

<script>
import AdminLayout from "@layouts/AdminLayout";
import CafeForm from "@components/CafeForm";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "edit-cafe",
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    components: {
        CafeForm
    },
    props: {
        cafe: {
            type: Object,
            default: {
                title: '',
                size:'',
                price:'',
                attachments:'',
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

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
                <inertia-link :href="route('history-management-page')">{{ _trans('label.shared.History') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.Create') }}</li>
        </ul>
    </div>
    <HistoryForm :history="history"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'post'"
                  :url="route('post-history')">
    </HistoryForm>
</template>

<script>
import AdminLayout from "@layouts/AdminLayout"
import HistoryForm from "@components/HistoryForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateHistory",
    components: {HistoryForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        history: {
            type: Object,
            default: {
                from_date: '',
                to_date: '',
                title: '',
                tags: [],
                detail: ''
            }
        },
        errors: {type: Object, default: {}},
        errorMessage: {type: String, default: ''},
        successMessage: {type: String, default: ''}
    },
})
</script>

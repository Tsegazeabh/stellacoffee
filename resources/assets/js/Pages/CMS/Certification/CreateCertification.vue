<template>
    <div class="breadcrump">
        <ul>
            <li>
                <inertia-link :href="route('home')">{{_trans('menu.Home')}}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('dashboard')">{{_trans('menu.CMS')}}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('certification-management-page')">{{_trans('label.shared.History')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <certification-form :certification="certification"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'post'"
                  :url="route('post-certification')">
    </certification-form>
</template>

<script>
    import CMSLayout from "@layouts/CMSLayout"
    import HistoryForm from "@components/HistoryForm"

    export default {
        name: "CreateHistory",
        components: {HistoryForm},
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        props: {
            certification: {
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
    }
</script>

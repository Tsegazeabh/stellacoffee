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
                <inertia-link :href="route('history-management-page')">{{_trans('label.shared.History')}}</inertia-link>
            </li>
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <history-form :history="history"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'put'"
                  :url="route('edit-history', history.id)">
    </history-form>
</template>

<script>
    import CMSLayout from "@layouts/CMSLayout";
    import HistoryForm from "@components/HistoryForm";

    export default {
        name: "edit-history",
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        components: {
            HistoryForm
        },
        props: {
            history: {
                type: Object,
                default: {
                    from_date: '',
                    to_date: '',
                    title: '',
                    tags: [],
                    detail: ''
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
    }
</script>

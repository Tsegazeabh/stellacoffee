<template>
    <div class="breadcrump">
        <ul>
            <li>
                <inertia-link :href="route('home')">{{_trans("menu.Home")}}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('dashboard')">{{_trans('menu.CMS')}}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('term-and-condition-management-page')">{{_trans("label.shared.Terms and Conditions")}}</inertia-link>
            </li>
            <li>{{_trans("action.create")}}</li>
        </ul>
    </div>
    <term-and-condition-form :term_and_condition="term_and_condition"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'post'"
               :url="route('post-term-and-condition')">
    </term-and-condition-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import TermAndConditionForm from "@components/TermAndConditionForm"

    export default {
        name: "CreateTermAndCondition",
        components: {TermAndConditionForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            term_and_condition: {type: Object, default: {title: '', detail: ''}},
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

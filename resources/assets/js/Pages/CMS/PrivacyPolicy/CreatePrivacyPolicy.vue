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
                <inertia-link :href="route('privacy-policy-management-page')">{{_trans("menu.Privacy Policy")}}</inertia-link>
            </li>
            <li>{{_trans("action.create")}}</li>
        </ul>
    </div>
    <privacy-policy-form :privacy_policy="privacy_policy"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'post'"
               :url="route('post-privacy-policy')">
    </privacy-policy-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import PrivacyPolicyForm from "@components/PrivacyPolicyForm"

    export default {
        name: "CreatePrivacyPolicy",
        components: {PrivacyPolicyForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            privacy_policy: {
                type: Object,
                default: {
                    title: '',
                    detail: ''
                }
            },
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

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
                <inertia-link :href="route('partner-management-page')">{{_trans('label.shared.Partners')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <partner-form :partner="partner"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'post'"
               :url="route('post-partner')">
    </partner-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import PartnerForm from "@components/PartnerForm"

    export default {
        name: "CreatePartner",
        components: {PartnerForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            partner: {
                type: Object,
                default: {
                    title: '',
                    tags: [],
                    detail: '',
                    link:'',
                    attachments:''
                }},
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

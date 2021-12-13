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
                <inertia-link :href="route('service-type-management-page')">{{_trans('label.shared.Service Types')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <service-type-form :service_type="service_type"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'post'"
               :url="route('post-service-type')">
    </service-type-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout";
    import ServiceTypeForm from "@components/ServiceTypeForm"

    export default {
        name: "CreateServiceType",
        components: {ServiceTypeForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            service_type: {type: Object, default:
                {
                    name: '',
                    description: '',
                    name_lan: '',
                    description_lan: ''
                }},
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

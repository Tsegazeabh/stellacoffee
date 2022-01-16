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
                <inertia-link :href="route('country-management-page')">{{_trans('label.shared.Country')}}</inertia-link>
            </li>
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <country-form :country="country"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'put'"
               :url="route('edit-country', country.id)">
    </country-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout";
    import CountryForm from "@components/CountryForm";

    export default {
        name: "edit-country",
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        components: {
            CountryForm
        },
        props: {
            country: {
                type: Object,
                default: {
                    name: '',
                    description: '',
                    name_am: '',
                    description_am: '',
                    name_fr: '',
                    description_fr: '',
                    name_it: '',
                    description_it: ''
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

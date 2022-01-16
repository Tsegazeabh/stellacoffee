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
                <inertia-link :href="route('city-management-page')">{{_trans('label.shared.City')}}</inertia-link>
            </li>
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <city-form :city="city"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'put'"
               :url="route('edit-city', city.id)">
    </city-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout";
    import CityForm from "@components/CityForm";

    export default {
        name: "edit-city",
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        components: {
            CityForm
        },
        props: {
            city: {
                type: Object,
                default: {
                    name: '',
                    country_id:'',
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

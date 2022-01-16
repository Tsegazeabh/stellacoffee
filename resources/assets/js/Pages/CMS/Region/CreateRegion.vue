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
                <inertia-link :href="route('region-management-page')">{{_trans('label.shared.Region')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <region-form :region="region"
                 :countries="countries"
                 :error-message="errorMessage"
                 :success-message="successMessage"
                 :errors="errors"
                 :method="'post'"
                 :url="route('post-region')">
    </region-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import RegionForm from "@components/RegionForm"

    export default {
        name: "CreateRegion",
        components: {RegionForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            region:
                {type: Object, default:
                    {
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
                    required:true
                },

            countries:{
                type: Object,
                required:true
            },
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

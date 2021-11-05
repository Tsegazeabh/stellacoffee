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
                <inertia-link :href="route('roasting-service-management-page')">{{_trans('label.shared.Roasting Service')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <RoastingServiceForm :roasting_service="roasting_service"
                        :error-message="errorMessage"
                        :success-message="successMessage"
                        :errors="errors"
                        :method="'post'"
                        :url="route('post-roasting-service')">
    </RoastingServiceForm>
</template>
<script>
    import CMSLayout from "@layouts/CMSLayout"
    import RoastingServiceForm from "@components/RoastingServiceForm"

    export default {
        name: "CreateRoastingService",
        components: {RoastingServiceForm},
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        props: {
            roasting_service: {
                type: Object,
                default: {
                    title: '',
                    detail: '',
                    video_link:'',
                    tags: [],
                }
            },
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

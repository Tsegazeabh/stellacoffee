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
                <inertia-link :href="route('roasting-process-management-page')">{{_trans('label.shared.Roasting Process')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <RoastingProcessForm :roasting_process="roasting_process"
                        :error-message="errorMessage"
                        :success-message="successMessage"
                        :errors="errors"
                        :method="'post'"
                        :url="route('post-roasting-process')">
    </RoastingProcessForm>
</template>
<script>
    import CMSLayout from "@layouts/CMSLayout"
    import RoastingProcessForm from "@components/RoastingProcessForm"

    export default {
        name: "CreateRoastingProcess",
        components: {RoastingProcessForm},
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        props: {
            roasting_process: {
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

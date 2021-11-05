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
                <inertia-link :href="route('roasting-machine-management-page')">{{_trans('label.shared.Roasting Machine')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <RoastingMachineForm :roasting_machine="roasting_machine"
                        :error-message="errorMessage"
                        :success-message="successMessage"
                        :errors="errors"
                        :method="'post'"
                        :url="route('post-roasting-machine')">
    </RoastingMachineForm>
</template>
<script>
    import CMSLayout from "@layouts/CMSLayout"
    import RoastingMachineForm from "@components/RoastingMachineForm"

    export default {
        name: "CreateRoastingMachine",
        components: {RoastingMachineForm},
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        props: {
            roasting_machine: {
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

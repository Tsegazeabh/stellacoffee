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
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <RoastingProcessForm :roasting_process="roasting_process"
                        :error-message="errorMessage"
                        :success-message="successMessage"
                        :errors="errors"
                        :method="'put'"
                        :url="route('edit-roasting-process', roasting_process.id)">
    </RoastingProcessForm>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout";
    import RoastingProcessForm from "@components/RoastingProcessForm";
    import { defineComponent } from 'vue'

    export default defineComponent({
        name: "edit-roasting-process",
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        components: {
            RoastingProcessForm
        },
        props: {
            roasting_process: {
                type: Object,
                default: {
                    title: '',
                    detail: '',
                    video_link:'',
                    tags: [],
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
    })
</script>

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
                <inertia-link :href="route('history-management-page')">{{_trans('label.shared.Certification')}}</inertia-link>
            </li>
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <CertificationForm :certification="certification"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'post'"
                  :url="route('edit-certification', certification.id)">
    </CertificationForm>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout";
    import CertificationForm from "@components/CertificationForm";

    export default {
        name: "edit-history",
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        components: {
            CertificationForm
        },
        props: {
            certification: {
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
    }
</script>

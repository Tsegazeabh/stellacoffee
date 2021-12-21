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
                <inertia-link :href="route('certification-management-page')">{{_trans('label.shared.Certification')}}</inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <CertificationForm :certification="certification"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'post'"
                  :url="route('post-certification')">
    </CertificationForm>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import CertificationForm from "@components/CertificationForm"
    import {defineComponent} from 'vue'
    export default defineComponent({
        name: "CreateCertification",
        components: {CertificationForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            certification: {
                type: Object,
                default: {
                    title: '',
                    detail: '',
                    provided_date: '',
                    provider: '',
                    video_link:'',
                    tags: [],
                }
            },
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    })
</script>

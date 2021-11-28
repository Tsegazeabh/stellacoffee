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
                <inertia-link :href="route('main-slider-management-page')">{{_trans('label.shared.Main Sliders')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <main-slider-form :main_slider="main_slider"
               :error-message="errorMessage"
               :success-message="successMessage"
               :errors="errors"
               :method="'post'"
               :url="route('post-main-slider')">
    </main-slider-form>
</template>

<script>
    import AdminLayout from "@layouts/AdminLayout"
    import MainSliderForm from "@components/MainSliderForm"

    export default {
        name: "CreateMainSlider",
        components: {MainSliderForm},
        layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
        props: {
            main_slider: {
                type: Object,
                default: {
                    title: '',
                    tags: [],
                    detail: '',
                    attachments:''
                }},
            errors: {type: Object, default: {}},
            errorMessage: {type: String, default: ''},
            successMessage: {type: String, default: ''}
        },
    }
</script>

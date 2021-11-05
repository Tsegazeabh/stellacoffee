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
                <inertia-link :href="route('stella-coffee-origin-management-page')">{{_trans('label.shared.Stella Coffee Origin')}}</inertia-link>
            </li>
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <StellaCoffeeOriginForm :stella_coffee_origin="stella_coffee_origin"
                        :error-message="errorMessage"
                        :success-message="successMessage"
                        :errors="errors"
                        :method="'put'"
                        :url="route('edit-stella-coffee-origin', stella_coffee_origin.id)">
    </StellaCoffeeOriginForm>
</template>

<script>
    import CMSLayout from "@layouts/CMSLayout";
    import StellaCoffeeOriginForm from "@components/StellaCoffeeOriginForm";

    export default {
        name: "edit-stella-coffee-origin",
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        components: {
            StellaCoffeeOriginForm
        },
        props: {
            stella_coffee_origin: {
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

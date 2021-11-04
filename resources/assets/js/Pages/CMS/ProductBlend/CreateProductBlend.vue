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
                <inertia-link :href="route('product-blend-management-page')">{{_trans('label.shared.ProductBlend')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <ProductBlendForm :product_blend="product_blend"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'post'"
                  :url="route('post-product-blend')">
    </ProductBlendForm>
</template>

<script>
    import CMSLayout from "@layouts/CMSLayout"
    import ProductBlendForm from "@components/ProductBlendForm"

    export default {
        name: "CreateProductBlend",
        components: {ProductBlendForm},
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        props: {
            product_blend: {
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

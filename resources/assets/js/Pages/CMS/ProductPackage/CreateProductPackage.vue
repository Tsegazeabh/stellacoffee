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
                <inertia-link :href="route('product-package-management-page')">{{_trans('label.shared.ProductBlend')}}</inertia-link>
            </li>
            <li>{{_trans('action.create')}}</li>
        </ul>
    </div>
    <ProductPackageForm :product_package="product_package"
                      :error-message="errorMessage"
                      :success-message="successMessage"
                      :errors="errors"
                      :method="'post'"
                      :url="route('post-product-package')">
    </ProductPackageForm>
</template>
<script>
    import CMSLayout from "@layouts/CMSLayout"
    import ProductPackageForm from "@components/ProductPackageForm"

    export default {
        name: "CreateProductPackage",
        components: {ProductPackageForm},
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        props: {
            product_package: {
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

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
                <inertia-link :href="route('product-package-management-page')">{{_trans('label.shared.Product Package')}}</inertia-link>
            </li>
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <ProductPackageForm :product_package="product_package"
                      :error-message="errorMessage"
                      :success-message="successMessage"
                      :errors="errors"
                      :method="'put'"
                      :url="route('edit-product-package', product_package.id)">
    </ProductPackageForm>
</template>

<script>
    import CMSLayout from "@layouts/CMSLayout";
    import ProductPackageForm from "@components/ProductPackageForm";

    export default {
        name: "edit-product-package",
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        components: {
            ProductPackageForm
        },
        props: {
            product_package: {
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

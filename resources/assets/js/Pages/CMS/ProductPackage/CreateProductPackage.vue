<template>
    <div class="breadcrump">
        <ul>
            <li>
                <inertia-link :href="route('home')">{{ _trans('menu.Home') }}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('dashboard')">{{ _trans('menu.CMS') }}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('product-package-management-page')">
                    {{ _trans('label.shared.Product Package') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
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
import AdminLayout from "@layouts/AdminLayout"
import ProductPackageForm from "@components/ProductPackageForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateProductPackage",
    components: {ProductPackageForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        product_package: {
            type: Object,
            default: {
                title: '',
                size:'',
                price:'',
                detail: '',
                video_link: '',
                tags: [],
            }
        },
        errors: {type: Object, default: {}},
        errorMessage: {type: String, default: ''},
        successMessage: {type: String, default: ''}
    },
})
</script>

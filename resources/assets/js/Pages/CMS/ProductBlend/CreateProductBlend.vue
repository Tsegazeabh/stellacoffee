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
                <inertia-link :href="route('product-blend-management-page')">
                    {{ _trans('label.shared.Product Blend') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
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
import AdminLayout from "@layouts/AdminLayout"
import ProductBlendForm from "@components/ProductBlendForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateProductBlend",
    components: {ProductBlendForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        product_blend: {
            type: Object,
            default: {
                title: '',
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

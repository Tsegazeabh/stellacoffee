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
            <li>{{_trans('action.edit')}}</li>
        </ul>
    </div>
    <ProductBlendForm :product_blend="product_blend"
                  :error-message="errorMessage"
                  :success-message="successMessage"
                  :errors="errors"
                  :method="'put'"
                  :url="route('edit-product-blend', product_blend.id)">
    </ProductBlendForm>
</template>

<script>
    import CMSLayout from "@layouts/CMSLayout";
    import ProductBlendForm from "@components/ProductBlendForm";

    export default {
        name: "edit-product-blend",
        layout: (h, page) => h(CMSLayout, [page]), // if you want to use different persistence layout,
        components: {
            ProductBlendForm
        },
        props: {
            product_blend: {
                type: Object,
                default: {
                    from_date: '',
                    to_date: '',
                    title: '',
                    tags: [],
                    detail: ''
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

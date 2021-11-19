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
                <inertia-link :href="route('shops-management-page')">
                    {{ _trans('label.shared.Sales Locations') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <shop-form :shop="shop"
               :errors="errors"
               :method="'put'"
               :url="route('update-shop', shop.id)">
    </shop-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import ShopForm from "@components/Forms/ShopForm";

export default defineComponent({
    name: "shop-editor",
    components: {ShopForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        shop: {
            type: Object,
            default: {
                country_id: '',
                city_id: '',
                shop_address:'',
                title: '',
                detail: '',
                longitude: '',
                latitude: '',
                video_link: '',
                tags: [],
            }
        }
    },
})
</script>

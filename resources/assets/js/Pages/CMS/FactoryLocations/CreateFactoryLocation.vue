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
                <inertia-link :href="route('factory-locations-management-page')">
                    {{ _trans('label.shared.Factory Locations') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <factory-location-form :factory_location="factory_location"
                             :errors="errors"
                             :method="'post'"
                             :url="route('post-factory-location')">
    </factory-location-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import FactoryLocationForm from "@components/Forms/FactoryLocationForm";

export default defineComponent({
    name: "create-factory-location",
    components: {FactoryLocationForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        factory_location: {
            type: Object,
            default: {
                country_id: '',
                city_id: '',
                factory_address:'',
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

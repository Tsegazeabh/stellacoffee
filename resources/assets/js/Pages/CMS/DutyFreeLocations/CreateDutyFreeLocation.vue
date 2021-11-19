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
                <inertia-link :href="route('duty-free-locations-management-page')">
                    {{ _trans('label.shared.Duty Free Locations') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <duty-free-location-form :duty_free_location="duty_free_location"
                         :errors="errors"
                         :method="'post'"
                         :url="route('post-duty-free-location')">
    </duty-free-location-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import DutyFreeLocationForm from "@components/Forms/DutyFreeLocationForm";

export default defineComponent({
    name: "create-duty-free-location",
    components: {DutyFreeLocationForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        duty_free_location: {
            type: Object,
            default: {
                country_id: '',
                airport_name:'',
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

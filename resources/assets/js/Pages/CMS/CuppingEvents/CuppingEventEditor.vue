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
                <inertia-link :href="route('cupping-events-management-page')">
                    {{ _trans('label.shared.Cupping Events') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <cupping-event-form :cupping_event="cupping_event"
                            :errors="errors"
                            :method="'put'"
                            :url="route('update-cupping-event', cupping_event.id)">
    </cupping-event-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import CuppingEventForm from "@components/Forms/CuppingEventForm";

export default defineComponent({
    name: "cupping-event-editor",
    components: {CuppingEventForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        cupping_event: {
            type: Object,
            default: {
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

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
                <inertia-link :href="route('export-destinations-management-page')">
                    {{ _trans('label.shared.Export Destination') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <export-destination-form :export_destination="export_destination"
                             :errors="errors"
                             :method="'put'"
                             :url="route('update-export-destination', export_destination.id)">
    </export-destination-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import ExportDestinationForm from "../../../Components/Forms/ExportDestinationForm";

export default defineComponent({
    name: "export-destination-editor",
    components: {
        ExportDestinationForm
    },
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        export_destination: {
            type: Object,
            default: {
                country_id:'',
                title: '',
                detail: '',
                longitude: '',
                latitude: '',
                video_link:'',
                tags: [],
            }
        },
        errors: {type: Object, default: {}}
    },
})
</script>

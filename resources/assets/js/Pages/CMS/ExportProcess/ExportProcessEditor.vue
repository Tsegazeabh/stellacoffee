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
                <inertia-link :href="route('export-process-management-page')">
                    {{ _trans('label.shared.Export Process') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.edit') }}</li>
        </ul>
    </div>
    <export-process-form :export_process="export_process"
                         :method="'put'"
                         :url="route('update-export-process', export_process.id)">
    </export-process-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import ExportProcessForm from "../../../Components/Forms/ExportProcessForm";

export default defineComponent({
    name: "export-process-editor",
    components: {ExportProcessForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        export_process: {
            type: Object,
            default: {
                title: '',
                detail: '',
                video_link: '',
                tags: [],
            }
        },
    }
})
</script>

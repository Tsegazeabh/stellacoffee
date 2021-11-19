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
                <inertia-link :href="route('cupping-procedures-management-page')">
                    {{ _trans('label.shared.Cupping Procedures') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <cupping-procedure-form :cupping_procedure="cupping_procedure"
                            :errors="errors"
                            :method="'post'"
                            :url="route('post-cupping-procedure')">
    </cupping-procedure-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import CuppingProcedureForm from "../../../Components/Forms/CuppingProcedureForm";

export default defineComponent({
    name: "create-cupping-process",
    components: {CuppingProcedureForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        cupping_procedure: {
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

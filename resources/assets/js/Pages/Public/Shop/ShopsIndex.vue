<template>
    <Portal target="#breadcrumb">
        <div class="breadcrumb">
            <ul>
                <li>
                    <inertia-link :href="route('home')">{{ _trans('menu.Home') }}</inertia-link>
                </li>
                <li>
                    <inertia-link :href="route('home')">{{ _trans('menu.About') }}</inertia-link>
                </li>
                <li>{{ _trans('menu.Shops') }}</li>
            </ul>
        </div>
    </Portal>
</template>

<script>
import {defineComponent} from "vue";
import ContentsLayout2 from "@layouts/ContentsLayout2";

export default defineComponent({
    name: "shops-index",
    layout: (h, page) => h(ContentsLayout2, [page]), // if you want to use different persistence layout,
    props: {
        contents: {
            type: Object,
            required: true,
            default: {}
        }
    }
})
</script>

<template>
<!--    <template #header>-->
<!--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
<!--            Dashboard-->
<!--        </h2>-->
<!--    </template>-->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <welcome/>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue';
import AppLayout from '@layouts/AppLayout.vue';
import Layout from '@layouts/Layout.vue';
import Welcome from '@jetstream/Welcome.vue';

// export {default as layout} from '@layouts/AppLayout.vue'

export default defineComponent({
    layout: (h, page) => h(Layout, [page, h('h2', { slot: 'header' }, 'Dashboard')]),
    components: {
        AppLayout,
        Welcome,
    },
})
</script>

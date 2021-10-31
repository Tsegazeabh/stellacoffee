require('./bootstrap');

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import Layout from "@layouts/Layout.vue";

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => {
        const page = require(`./Pages/${name}.vue`);
        page.layout = page.layout || Layout
        return page;
    },
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .mixin({methods: {route}})
            .mount(el);
    },
});

InertiaProgress.init({color: '#4B5563'});

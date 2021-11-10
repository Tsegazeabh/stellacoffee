require('./bootstrap');

import {createApp, h} from 'vue';
import {createInertiaApp, Link, Head} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import Layout from "@layouts/Layout.vue";
import {_trans} from "./shared/Localization.js";

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => {
        const page = require(`./Pages/${name}.vue`);
        page.layout = page.layout || Layout
        return page;
    },
    setup({el, app, props, plugin}) {
        return createApp({
            render: () => h(app, props)
        })
            .use(plugin)
            .component('InertiaLink', Link)
            .component('InertiaHead', Head)
            .mixin({methods: {route, _trans}})
            .directive('mobile-nav', {
                beforeMount(el, binding, vnode) {
                    el.clickOutsideEvent = function (event) {
                        // here we check that click was outside the el and his children
                        if (!(el == event.target || el.contains(event.target))) {
                            binding.value()
                        }
                    }
                    document.body.addEventListener('click', el.clickOutsideEvent)
                },
                unmounted(el) {
                    document.body.removeEventListener('click', el.clickOutsideEvent)
                }
            })
            .directive('accordion', {
                beforeMount(el, binding, vnode) {
                    el.clickOutsideEvent = function (event) {
                        // here we check that click was outside the el and his children
                        if (!(el == event.target || el.contains(event.target))) {
                            binding.value()
                        }
                    }
                    document.body.addEventListener('click', el.clickOutsideEvent)
                },
                unmounted(el) {
                    document.body.removeEventListener('click', el.clickOutsideEvent)
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({color: '#4B5563'});



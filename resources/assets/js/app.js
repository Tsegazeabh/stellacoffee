require('./bootstrap');

import {createApp, h} from 'vue';
import {createInertiaApp, Link, Head} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import Layout from "@layouts/Layout.vue";
import {_trans} from "./shared/Localization.js";
import Toaster from "@meforma/vue-toaster";


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
            .use(Toaster, {position: "top", duration: 3000, dismissible: true})
            .component('InertiaLink', Link)
            .component('InertiaHead', Head)
            .mixin({
                    methods: {
                        // @ts-ignore
                        route,
                        _trans,
                        // @ts-ignore
                        changeLanguage(lang) {
                            let url = '';
                            let currentRouteName = this.route().current();
                            if (currentRouteName != undefined) {
                                let queryParam = new Map();
                                if (this.route().params != null) {
                                    Object.keys(this.route().params).forEach((key) => {
                                        queryParam.set(key, this.route().params[key]);
                                    });
                                    if (!queryParam.has('lang')) {
                                        queryParam.set('lang', lang);
                                    } else {
                                        if (queryParam.get('lang') != lang) {
                                            queryParam.set('lang', lang);
                                        } else {
                                            return false;
                                        }
                                    }
                                } else {
                                    queryParam.set('lang', lang);
                                }

                                //build the url
                                url = this.route(currentRouteName, Object.fromEntries(queryParam));
                            } else {
                                let urlObj = new URL(window.location.href);

                                if (urlObj.searchParams.has('lang')) {
                                    if (urlObj.searchParams.get('lang') != lang) {
                                        urlObj.searchParams.set('lang', lang);
                                        url = urlObj.href;
                                    } else {
                                        return false;
                                    }
                                } else {
                                    urlObj.searchParams.set('lang', lang);
                                    url = urlObj.href;
                                }
                            }

                            // navigate
                            this.$inertia.visit(url);
                        }
                    }
                }
            )
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



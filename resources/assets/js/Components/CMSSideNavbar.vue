<template>
    <aside class="cms-side-navbar" v-show="!collapse" v-mobile-nav="hideOnClickOutside">
        <ul class="navbar">
            <template v-for="(menu,index) in menus" :key="index">
                <template v-if="!menu.submenus || menu.submenus.length==0">
                    <li class="border-light-gray">
                        <inertia-link :href="menu.route" class="active:font-bold">
                            {{ _trans('menu.' + menu.label) }}
                        </inertia-link>
                    </li>
                </template>
                <template v-else>
                    <li class="border-light-gray" :class="{'collapsed':menu.collapsed, 'expanded':!menu.collapsed}"
                        @click.stop.prevent="toggleDropdown(index)">
                        <a href="#" class="active:font-bold" @click.prevent>
                            <span class="inline-block flex-grow pr-5">
                            {{ _trans('menu.' + menu.label) }}
                            </span>
                            <span class="flex-none w-max"><i class="fa fa-angle-down"></i>  </span>
                        </a>

                        <ul class="dropdown">
                            <li v-for="submenu of menu.submenus">
                                <inertia-link :href="submenu.route">
                                    <i class="far fa-circle text-yellow-500"></i>&nbsp;
                                    {{ _trans('menu.' + submenu.label) }}
                                </inertia-link>
                            </li>
                        </ul>
                    </li>
                </template>
            </template>
        </ul>
    </aside>
</template>

<script>
import {defineComponent} from 'vue'
import route from "ziggy-js/src/js";

export default defineComponent({
    name: "cms-side-navbar",
    emits: ['toggleCollapse'],
    props: {
        collapse: {
            type: Boolean,
            default: false
        },
        breakpoint: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            collapsed: this.collapse,
            menus: [
                {
                    label: 'Users and Roles', route: '',
                    collapsed: true,
                    submenus: [
                        {label: 'Roles', route: route('roles.index')},
                        {label: 'Users', route: route('manage-accounts')},
                        {label: 'Role Permissions', route: route('role-permissions-page')},
                        // {label: 'Audit Trails', route: route('audits-index')},
                    ]
                },
                {
                    label: 'About Us', route: route("home"),
                    collapsed: true,
                    submenus: [
                        {label: "History", route: route('history-management-page'), active: false},
                        {label: "Success Stories", route: route('success-story-management-page'), active: false},
                        {label: "Certifications", route: route('certification-management-page'), active: false},
                        {label: "Stella Coffee Origins", route: route('stella-coffee-origin-management-page'), active: false},
                        {label: "Contact Us", url: "", active: false},
                    ]
                },
                {
                    label: 'Roasting', route: route("home"),
                    collapsed: true,
                    submenus: [
                        {label: "Roasting Process", route: route('roasting-process-management-page'), active: false},
                        {label: "Quality Control Process", route: route('quality-control-process-management-page'), active: false},
                        {label: "Our Roasting Machine ", route: route('roasting-machine-management-page'), active: false},
                        {label: "Roasting Guides", route: route('roasting-guide-management-page'), active: false},
                        {label: "Roasting Services", route: route('roasting-service-management-page'), active: false}
                    ]
                },
                {
                    label: 'Products', route: route("home"),
                    collapsed: true,
                    submenus: [
                        {label: "Packages", route: route('product-package-management-page'), active: false},
                        {label: "Blends", route: route('product-blend-management-page'), active: false},
                    ]
                },
                // {
                //     label: 'Find Us', route: route("home"),
                //     collapsed: true,
                //     submenus: [
                //         {label: "Export Destinations", route: route('export-destination-management-page'), active: false},
                //         {label: "Sales Locations", route: route('sales-location-management-page'), active: false},
                //         {label: "Duty Free Locations ", route: route('duty-free-location-management-page'), active: false},
                //         {label: "Our Stores", route: route('store-management-page'), active: false},
                //         {label: "Factory Location", route: route('factory-location-management-page'), active: false},
                //         {label: "Export Processes", route: route('export-process-management-page'), active: false},
                //     ]
                // },
                // {
                //     label: 'Cupping', route: route("home"),
                //     collapsed: true,
                //     submenus: [
                //         {label: "Cupping Procedures", route: route('cupping-procedure-management-page'), active: false},
                //         {label: "Cupping Events", route: route('cupping-event-management-page'), active: false}
                //     ]
                // },
                // {
                //     label: 'News and Events', route: route("news-and-events-management-page"),
                //
                // },

                // {
                //     label: 'Other Contents', route: route('home'),
                //     collapsed: true,
                //     submenus: [
                //         {label: 'Partners', route: route('partner-management-page')},
                //         {label: 'FAQs', route: route('faq-management-page')},
                //         {label: 'Main Sliders', route: route('main-slider-management-page')},
                //         {label: 'Privacy Policy', route: route('privacy-policy-management-page')},
                //         {label: 'Terms and Conditions', route: route('term-and-condition-management-page')},
                //     ]
                // },

                // {
                //     label: 'Settings', route: route("home"),
                //     collapsed: true,
                //     submenus: [
                //         {label: 'FAQ Groups', route: route('faq-group-management-page')},
                //         {label: 'Country', route: route('country-management-page')},
                //         {label: 'Region', route: route('region-management-page')},
                //         {label: 'City', route: route('city-management-page')},
                //         {label: 'Subcity', route: route('subcity-management-page')},
                //         {label: 'Woreda', route: route('woreda-management-page')},
                //     ]
                // },

            ]
        }
    },

    methods: {
        toggleDropdown(index) {
            this.menus[index].collapsed = !this.menus[index].collapsed
        },

        hideOnClickOutside() {
            if (window.innerWidth < this.breakpoint.md) {
                this.collapsed = true
                this.$emit('toggleCollapse', this.collapsed)
            }
        },
    }
})
</script>

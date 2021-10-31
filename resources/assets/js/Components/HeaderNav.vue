<template>
    <nav class="main-navbar absolute w-full px-12 z-50 bg-white">
        <div class="brand">
            <a href="/" class="flex flex-wrap border w-32 my-3">
                <img src="images/stella_coffee_logo.jpg" class="object-contain"/>
            </a>
        </div>
        <ul class="menu list-none flex justify-center">
            <li class="py-6 px-4" v-for="menu in menus" :class="menu.submenus && menu.submenus.length>0?'dropdown':''">
                <a class="py-3" href="/">{{ menu.label }}</a>
                <template v-if="menu.submenus && menu.submenus.length>0">
                    <ul>
                        <li v-for="submenu in menu.submenus">
                            <a class="py-3" href="/">{{ submenu.label }}</a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </nav>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    name: "header-nav",
    data() {
        return {
            menus: [
                {
                    label: "About", url: "", active: true,
                    submenus: [
                        {label: "History", url: "", active: false},
                        {label: "Success Stories", url: "", active: false},
                        {label: "Certifications", url: "", active: false},
                        {label: "Stella Coffee Origins", url: "", active: false},
                        {label: "Contact Us", url: "", active: false},
                    ]
                },
                {
                    label: "Roasting", url: "", active: false,
                    submenus: [
                        {label: "Roasting Process", url: "", active: false},
                        {label: "Quality Control Process", url: "", active: false},
                        {label: "Our Roasting Machine ", url: "", active: false},
                        {label: "Roasting Guides", url: "", active: false},
                        {label: "Roasting Services", url: "", active: false}
                    ]
                },
                {
                    label: "Products", url: "", active: false,
                    submenus: [
                        {label: "Packages", url: "", active: false},
                        {label: "Blends", url: "", active: false},
                    ]
                },
                {
                    label: "Find Us", url: "", active: false,
                    submenus: [
                        {label: "Export Destinations", url: "", active: false},
                        {label: "Locations", url: "", active: false},
                        {label: "Duty Free Locations ", url: "", active: false},
                        {label: "Shops", url: "", active: false},
                        {label: "Factory Location", url: "", active: false},
                        {label: "Export Processes", url: "", active: false},
                    ]
                },
                {
                    label: "Cupping", url: "", active: false, submenus: [
                        {label: "Cupping Procedures", url: "", active: false},
                        {label: "Cupping Events", url: "", active: false}
                    ]
                },
                {
                    label: "News and Events", url: "", active: false
                }
            ]
        }
    },
    mounted() {
        console.log(this.menus)
    }
})
</script>

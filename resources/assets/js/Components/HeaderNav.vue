<template>
    <nav class="main-navbar w-full px-12 bg-white">
        <div class="brand">
            <a href="/" class="flex flex-wrap border w-32 my-3">
                <img src="/images/stella_coffee_logo.jpg" class="object-contain"/>
            </a>
        </div>
        <ul class="menu list-none flex justify-center">
            <li class="py-6 px-4" v-for="menu in menus" :class="menu.submenus && menu.submenus.length>0?'dropdown':''">
                <a class="py-3" href="/">{{ menu.label }}</a>
                <template v-if="menu.submenus && menu.submenus.length>0">
                    <ul>
                        <li v-for="submenu in menu.submenus">
                            <a class="py-3" :href="submenu.url">{{ submenu.label }}</a>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </nav>
</template>

<script>
import {defineComponent} from "vue";
import {getMenus} from "@shared/Menu";

export default defineComponent({
    name: "header-nav",
    data() {
        return {
            menus: getMenus()
        }
    },
    mounted() {
    }
})
</script>

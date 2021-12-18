<template>
    <inertia-head title="Stella Coffee"></inertia-head>
    <top-header></top-header>
    <header-nav class="content-layout-menu"></header-nav>
    <main class="main">
        <div class="grid md:grid-cols-2">
            <div class="org-info">
                <slot name="breadcrumb">
                    <div class="breadcrumb">
                        <ul>
                            <li>
                                <inertia-link :href="route('home')" >{{_trans('menu.Home')}}</inertia-link>
                            </li>
                            <li>
                                <inertia-link :href="route('home')" >{{_trans(menuValue)}}</inertia-link>
                            </li>
                            <li>
                                <inertia-link :href="route('home')">
                                    {{_trans(subMenuValue)}}
                                </inertia-link>
                            </li>
                            <li>{{ _trans('action.Index') }}</li>
                        </ul>
                    </div>
                </slot>
                <div class="max-h-screen overflow-y-auto bg-black">
                    <slot name="summary-sect"></slot>
                </div>
            </div>
            <div class="content-wrapper col-span-1 bg-white p-10">
                <slot></slot>
            </div>
        </div>
    </main>
    <site-footer></site-footer>
</template>

<script>
import TopHeader from "@components/TopHeader";
import HeaderNav from "@components/HeaderNav";
import SiteFooter from "@components/SiteFooter";
import {defineComponent} from "vue";

export default defineComponent({
    name: "contents-layout2",
    components: {SiteFooter, HeaderNav, TopHeader},
    inject: ['menu_name','sub_menu_name'],
    data(){
        return{
          menu:'menu.',
          subMenu:'menu.'
        }
    },
    computed:{
        menuValue(){
            return this.menu + this.menu_name;
        },
        subMenuValue(){
            return this.subMenu + this.sub_menu_name;
        }
    }
})
</script>
<style scoped>
.main {
    background-image: url("http://127.0.0.1:8000/images/bg-image-3.jpg");
    background-position: top left;
    background-size: cover;
    background-attachment: scroll;
}

.content-wrapper {

    @apply overflow-auto;
    max-height: 100vh;
}
</style>

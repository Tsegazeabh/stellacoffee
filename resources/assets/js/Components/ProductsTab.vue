<template>
    <div id="product-tabs" class="">
        <div class="tab-headers-cont">
            <a href="#products-tab" class="index-header h2 justify-center text-center"
               :class="{'active':currentTab=='packages'}" @click.prevent.stop="currentTab = 'packages'">
                <span>Packages</span>
                <span>&nbsp;</span>
            </a>
            <a href="#products-tab" class="index-header h2 justify-center text-center"
               :class="{'active':currentTab=='blends'}" @click.prevent.stop="currentTab = 'blends'">
                <span>Blends</span>
                <span>&nbsp;</span>
            </a>
        </div>

        <div id="products-tab">
            <div class="products-container">
                <keep-alive>
                    <component v-bind:is="currentTabComponent"></component>
                </keep-alive>
            </div>
        </div>
    </div>
</template>

<script>
import ProductCard from "./ProductCard";
import IndexHeader from "./IndexHeader";
import PackagesTab from "./PackagesTab";
import BlendsTab from "./BlendsTab";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ProductsTab",
    components: {BlendsTab, PackagesTab, IndexHeader, ProductCard},
    data() {
        return {
            currentTab: 'packages'
        }
    },
    computed: {
        currentTabComponent() {
            return this.currentTab + '-tab';
        }
    }
})
</script>

<style scoped>

</style>

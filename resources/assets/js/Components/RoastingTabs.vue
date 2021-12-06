<template>
    <div id="roasting-tabs">
        <div class="menu">
            <ul>
                <li :class="{'active':currentTab=='roasting-process'}">
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-process'">
                        <strong>Roasting Process</strong>
                    </a>
                </li>
                <li :class="{'active':currentTab=='quality-control-process'}">
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='quality-control-process'">
                        <strong>Quality Control Process</strong>
                    </a>
                </li>
                <li :class="{'active':currentTab=='roasting-machines'}">
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-machines'">
                        <strong>Our Roasting Machine</strong>
                    </a>
                </li>
                <li :class="{'active':currentTab=='roasting-guides'}">
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-guides'">
                        <strong>Roasting Guides</strong>
                    </a>
                </li>
                <li :class="{'active':currentTab=='roasting-service'}">
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-service'">
                        <strong>Roasting Services</strong>
                    </a>
                </li>
            </ul>

        </div>
        <div class="tab-container" id="roasting-tabs-cont">
            <keep-alive>
                <component v-bind:is="currentTabComponent"></component>
            </keep-alive>
            <!--            <div id="tab-1">-->
            <!--                <index-header class="h2 justify-center text-center" title="Step 1"></index-header>-->
            <!--                <p class="text-xl">Hello! We are Cuppino Coffee Production, a company that is passionate about making-->
            <!--                    and selling coffee with a great flavor. Our team of dedicated coffee experts celebrates exceptional-->
            <!--                    coffee brands and roasters by providing our guests the unique opportunity to try coffee the highest-->
            <!--                    quality.</p>-->

            <!--            </div>-->
        </div>
    </div>

</template>

<script>

import {defineComponent} from 'vue'
import RoastingServiceTab from "./RoastingServiceTab";
import RoastingGuidesTab from "./RoastingGuidesTab";
import RoastingMachinesTab from "./RoastingMachinesTab";
import QualityControlProcessTab from "./QualityControlProcessTab";
import RoastingProcessTab from "./RoastingProcessTab";

export default defineComponent({
    name: "RoastingTabs",
    components: {
        RoastingProcessTab,
        RoastingServiceTab,
        RoastingGuidesTab,
        RoastingMachinesTab,
        QualityControlProcessTab
    },
    data() {
        return {
            currentTab: 'roasting-process'
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

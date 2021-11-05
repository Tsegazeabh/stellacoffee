<template>
    <div id="roasting-tabs">
        <div class="menu">
            <ul>
                <li class="active">
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-process'"><strong>Roasting Process</strong></a>
                </li>
                <li>
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='qc-process'"><strong>Quality Control Process</strong></a>
                </li>
                <li>
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-machines'"><strong>Our Roasting Machine</strong></a>
                </li>
                <li>
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-guides'"><strong>Roasting Guides</strong></a>
                </li>
                <li>
                    <a href="#roasting-tabs-cont" @click.prevent.stop="currentTab='roasting-service'"><strong>Roasting Services</strong></a>
                </li>
            </ul>

        </div>
        <div class="tab-container" id="roasting-tabs-cont">
            <div id="tab-1">
                <index-header class="h2 justify-center text-center" title="Step 1"></index-header>
                <p class="text-xl">Hello! We are Cuppino Coffee Production, a company that is passionate about making
                    and selling coffee with a great flavor. Our team of dedicated coffee experts celebrates exceptional
                    coffee brands and roasters by providing our guests the unique opportunity to try coffee the highest
                    quality.</p>

            </div>
        </div>
    </div>

</template>

<script>

import IndexHeader from "./IndexHeader";

export default {
    name: "RoastingTabs",
    components: {IndexHeader},
    data() {
        return {
            currentTab: 'roasting-process'
        }
    },
    computed: {
        currentTabComponent(){
            return this.currentTab + '-tab';
        }
    }
}
</script>

<style scoped>

</style>

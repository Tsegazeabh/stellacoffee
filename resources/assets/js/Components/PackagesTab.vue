<template>
    <product-card v-for="pkg of packages" :product="pkg"></product-card>
    <div class="btn-container" v-if="packages && packages.length>0">
        <inertia-link :href="route('content-index-page', 'product-package')" class="btn">
            View all packages &raquo;
        </inertia-link>
    </div>
</template>

<script>
import ProductCard from "./ProductCard";
import {defineComponent, onMounted, ref} from 'vue'
import axios from "axios";

export default defineComponent({
    name: "packages-tab",
    components: {ProductCard},

    setup() {
        const packages = ref([])
        const fetchLatestBlends = () => {
            axios.get(route('latest-product-packages')).then(
                (res) => {
                    packages.value = res.data
                },
                (error) => {
                    packages.value = []
                },
            )
        }

        onMounted(fetchLatestBlends)

        return {
            packages
        }
    }
})
</script>

<template>
    <product-card v-for="blend of blends" :product="blend"></product-card>
    <div class="btn-container">
        <inertia-link :href="route('content-index-page', 'product-blend')" class="btn">
            View all blends &raquo;
        </inertia-link>
    </div>
</template>

<script>
import ProductCard from "./ProductCard";
import {defineComponent, ref, onMounted} from 'vue'
import axios from "axios";

export default defineComponent({
    name: "BlendsTab",
    components: {ProductCard},

    setup() {
        const blends = ref([])
        const fetchLatestBlends = () => {
            axios.get(route('latest-product-blend')).then(
                (res) => {
                    blends.value = res.data
                },
                (error) => {
                    blends.value = []
                },
            )
        }

        onMounted(fetchLatestBlends)

        return {
            blends
        }
    }
})
</script>

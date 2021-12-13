<template>
    <inertia-link :href="product.url" class="product-card">
        <div class="product-image">
            <img :src="product.contentable.first_image['src']" :srcset="product.contentable.first_image['srcset']"/>
        </div>
        <div class="product-name">{{ product.contentable.title }}</div>
        <div class="product-description">{{ product.contentable.description }}</div>
        <div class="product-price">{{ product.contentable.price }}</div>
    </inertia-link>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "product-card",
    props: {
        product: {
            type: Object,
            required: true
        }
    }
})
</script>

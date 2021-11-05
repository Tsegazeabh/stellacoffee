<template>
    <div class="product-card">
        <div class="product-image">
            <img :src="product.image" />
        </div>
        <div class="product-name">{{product.name}}</div>
        <div class="product-description">{{product.description}}</div>
        <div class="product-price">{{product.price}}</div>
    </div>
</template>

<script>
export default {
    name: "product-card",
    props:{
        product:{
            type:Object,
            required:true
        }
    }
}
</script>

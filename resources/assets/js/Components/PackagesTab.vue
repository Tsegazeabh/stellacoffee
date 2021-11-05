<template>
    <product-card v-for="pkg of packages" :product="pkg"></product-card>
</template>

<script>
import ProductCard from "./ProductCard";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "packages-tab",
    components: {ProductCard},
    data() {
        return {
            packages: [
                {
                    name: 'Lavazza Crema e Gusto',
                    image: 'images/stella_coffee_logo.jpg',
                    description: 'Lavazza Crema e Gusto Espresso is a special blend of Robusta and Arabica beans.',
                    price: '$14.00'
                },
                {
                    name: 'Maxwell House Original Roast Ground Coffee',
                    image: 'images/stella_coffee_logo.jpg',
                    description: 'Ground Coffee Having a very interesting history, this coffee is easily recognized all over the globe.',
                    price: '$14.00'
                },
                {
                    name: 'Douwe Egberts Filter Blend Ground Coffee Medium Roast',
                    image: 'images/stella_coffee_logo.jpg',
                    description: 'Douwe Egberts Real Coffee is a blend of the world’s finest quality beans.',
                    price: '$14.00'
                },
                {
                    name: 'Don Francisco Hawaiian Hazelnut Coffee 12 Ounce',
                    image: 'images/stella_coffee_logo.jpg',
                    description: 'One of the best hazelnut coffees, and if you are a big coffee drinker, you must try it.',
                    price: '$14.00'
                },
                {
                    name: 'Guilt-Free Decaf by Findlays Finest Gourmet Coffee',
                    image: 'images/stella_coffee_logo.jpg',
                    description: '100% Arabic beans roasted to perfection to bring out the natural flavor of coffee.',
                    price: '$14.00'
                },
                {
                    name: 'Kicking Horse Coffee Dark Whole Bean Coffee 12.3',
                    image: 'images/stella_coffee_logo.jpg',
                    description: 'Kicking Horse Dark Coffee is one of the best when it comes to the true taste.',
                    price: '$14.00'
                },
            ]
        }
    }
})
</script>

<style scoped>

</style>

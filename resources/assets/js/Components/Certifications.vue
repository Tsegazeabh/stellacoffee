<template>
    <div id="partners-slider">
        <div class="slider-header">
            <index-header class="h2 justify-center text-center" title="Certificates"></index-header>
        </div>
        <div class="grid grid-cols-5 gap-10">
            <div class="col-span-2">
                <div class="swiper-container">
                    <swiper @swiper="setControlledSwiper"
                            :modules="modules"
                            :slides-per-view="1">
                        <swiper-slide v-for="(certificate,index) in certificates" :key="index" class="header-slider">
                            <span class="slider-header-text">{{ certificate.title }}</span>
                            <div class="w-full flex flex-col">
                                <img :src="certificate.image" class="w-full object-fill">
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
            <div class="col-span-3">
                <div class="swiper-container">
                    <swiper
                        :modules="[Controller]"
                        :controller="{ control: controlledSwiper }"
                        :space-between="100"
                        :slides-per-view="3"
                        autoplay
                        :parallax="true"
                        :navigation="true">
                        <swiper-slide v-for="certificate in certificates">
                            <img :src="certificate.image" class="w-full object-fill">
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import {defineComponent, ref} from 'vue'
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Scrollbar, Controller, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

export default defineComponent({
    name: "certifications",
    components: {Swiper, SwiperSlide},
    setup() {
        const controlledSwiper = ref(null);
        const setControlledSwiper = (swiper) => {
            controlledSwiper.value = swiper;
        }
        return {
            Controller,
            modules: [Navigation, Pagination, Scrollbar, Controller, A11y, Autoplay, Parallax, EffectCards],
            certificates: [
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Fair Trade",
                    description: "Certificate 1",
                    provider: "Fair Trade America",
                    date: ""
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Bird Friendly",
                    description: "Certificate 1",
                    provider: "Rainforest Alliance",
                    date: ""
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Rainforest Alliance",
                    description: "Certificate 1",
                    provider: "Ethiopia Coffee Quality Control",
                    date: ""
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Carbon Neutral",
                    description: "Certificate 1",
                    provider: "Ethiopia Coffee Quality Control",
                    date: ""
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Organic",
                    description: "Certificate 1",
                    provider: "Ethiopia Coffee Quality Control",
                    date: ""
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Direct Trade",
                    description: "Certificate 1",
                    provider: "Ethiopia Coffee Quality Control",
                    date: ""
                },
            ],
            setControlledSwiper,
            controlledSwiper,
            mainSliders: [],
        }
    }
})
</script>

<style scoped>

</style>

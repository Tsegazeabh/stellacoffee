<template>
    <div id="certificates-slider">
        <div class="slider-header">
            <index-header class="h2 justify-center text-center" title="Certificates"></index-header>
        </div>
        <div class="grid grid-cols-5 gap-10">
            <div class="col-span-4">
                <div class="flex flex-wrap w-full">
                    <!--                    :controller="{ control: controlledSwiper }"-->
                    <swiper
                        :parallax="true"
                        :modules="modules"
                        :navigation="true"
                        autoplay
                        :slides-per-view="1">
                        <swiper-slide v-for="(certificate,index) in certificates" :key="index" class="header-slider">
                            <div class="grid grid-cols-3 gap-10">
                                <img :src="certificate.image" class="col-span-1 object-fill">
                                <div class="col-span-2 flex flex-col">
                                    <h3 class="text-xl text-stella font-black my-3">{{ certificate.name }}</h3>
                                    <p class="my-2">{{ certificate.description }}</p>
                                    <div class="py-4 pr-20 flex flex-wrap justify-between items-center text-roast-dark font-semibold">
                                        <span>Provided by: {{ certificate.provider }}</span>
                                        <span>Date: {{ certificate.date }} </span>
                                    </div>
                                    <div class="py-4">
                                        <button class="border font-bold rounded p-3 bg-stella text-white">Download</button>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </div>
            </div>

            <!--                        @swiper="setControlledSwiper"-->
            <!--                        :modules="[Controller]"-->
            <div class="col-span-1">
                <div class="flex flex-col items-center">
                    <!--                    <swiper-->
                    <!--                        :direction="'vertical'"-->
                    <!--                        :freeMode="true"-->
                    <!--                        :space-between="30"-->
                    <!--                        :slides-per-view="3">-->
                    <!--                        <swiper-slide v-for="certificate in certificates">-->
                    <!--                            <img :src="certificate.image" class="w-full object-fill">-->
                    <!--                        </swiper-slide>-->
                    <!--                    </swiper>-->
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
import "swiper/css/free-mode"
import IndexHeader from "./IndexHeader";

export default defineComponent({
    name: "certifications",
    components: {IndexHeader, Swiper, SwiperSlide},
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
                    description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia",
                    provider: "Fair Trade America",
                    date: "Aug 02, 2016"
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Bird Friendly",
                    description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia",
                    provider: "Rainforest Alliance",
                    date: "Aug 02, 2017"
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Rainforest Alliance",
                    description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia",
                    provider: "Ethiopia Coffee Quality Control",
                    date: "Aug 02, 2018"
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Carbon Neutral",
                    description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia",
                    provider: "Ethiopia Coffee Quality Control",
                    date: "Aug 02, 2019"
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Organic",
                    description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia",
                    provider: "Ethiopia Coffee Quality Control",
                    date: "Aug 02, 2020"
                },
                {
                    image: "images/stella_coffee_logo.jpg",
                    name: "Direct Trade",
                    description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia. Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sed tempora corrupti officia",
                    provider: "Ethiopia Coffee Quality Control",
                    date: "Aug 02, 2021"
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

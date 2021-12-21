<template>
    <div id="certificates-slider">
        <div class="slider-header">
            <index-header class="h2 justify-center text-center" title="Certificates"></index-header>
        </div>
        <div class="flex flex-wrap justify-center items-center w-full">
            <div class="flex flex-wrap w-full">
                <swiper
                    :parallax="true"
                    :modules="modules"
                    :navigation="true"
                    autoplay
                    :slides-per-view="1">
                    <swiper-slide v-for="(certificate,index) in certificates" :key="index" class="header-slider">
                        <div class="grid grid-cols-3 gap-10">
                            <div class="col-span-1 flex flex-wrap justify-center items-center">
                                <img :src="certificate.contentable.thumb_url" class="object-fill h-full w-full">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <h3 class="text-xl text-stella font-black my-3">{{
                                        certificate.contentable.title
                                    }}</h3>
                                <p class="my-2">{{ certificate.contentable.lead_paragraph }}</p>
                                <div
                                    class="py-4 pr-20 flex flex-wrap justify-between items-center text-roast-dark font-semibold">
                                    <span>Provided by: {{ certificate.contentable.provider }}</span>
                                    <span>Date: {{ formatDate(certificate.contentable.provided_date) }} </span>
                                </div>
                                <div class="py-4">
                                    <button class="border font-bold rounded p-3 bg-stella text-white">
                                        {{ _trans('label.shared.Download') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>


    </div>
</template>

<script>
import {defineComponent, ref, onMounted} from 'vue'
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Scrollbar, Controller, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import "swiper/css/free-mode"
import IndexHeader from "./IndexHeader";
import axios from "axios";
import moment from "moment";

export default defineComponent({
    name: "certifications",
    components: {IndexHeader, Swiper, SwiperSlide},
    setup() {
        const certificates = ref([])
        const controlledSwiper = ref(null);

        const formatDate = (date) => {
            return moment(String(date)).format('MMM DD, YYYY')
        }

        const fetchCertificates = () => {
            axios.get(route('latest-certification')).then(
                (res) => {
                    certificates.value = res.data
                    console.log(certificates.value);
                },
                (error) => {
                    certificates.value = []
                },
            )
        }

        const setControlledSwiper = (swiper) => {
            controlledSwiper.value = swiper;
        }

        onMounted(fetchCertificates)

        return {
            Controller,
            modules: [Navigation, Pagination, Scrollbar, Controller, A11y, Autoplay, Parallax, EffectCards],
            certificates,
            formatDate,
            /*certificates: [
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
            ],*/
            setControlledSwiper,
            controlledSwiper,
            mainSliders: [],
        }
    }
})
</script>

<style scoped>

</style>

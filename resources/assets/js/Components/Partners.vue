<template>
    <div id="partners-slider">
        <div class="slider-header">
            <index-header class="h2 justify-center text-center" title="Our Partners"></index-header>
        </div>
        <div class="swiper-container">
            <swiper
                :modules="modules"
                :space-between="100"
                autoplay
                :breakpoints="swiperOptions.breakpoints"
                :parallax="true"
                :navigation="true">
                <swiper-slide v-for="partner in partners">
                    <partner-card :partner="partner"></partner-card>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue';
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
import IndexHeader from "./IndexHeader";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import PartnerCard from "./PartnerCard";

export default defineComponent({
    name: "partners",
    components: {PartnerCard, IndexHeader, Swiper, SwiperSlide},
    setup() {
        return {
            modules: [Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
            parallaxSwiperWidth: 0,
            swiperOptions: {
                breakpoints: {
                    799: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    800: {
                        slidesPerView: 5,
                        spaceBetween: 30
                    }
                }
            },
            partners: [
                {
                    name: "ABC Coffee Roasters",
                    logo: "images/stella_coffee_logo.jpg",
                    url: "",
                },
                {
                    name: "XYZ Coffee Roasters",
                    logo: "images/stella_coffee_logo.jpg",
                    url: "",
                },
                {
                    name: "XYZ Coffee Roasters",
                    logo: "images/stella_coffee_logo.jpg",
                    url: "",
                },
                {
                    name: "XYZ Coffee Roasters",
                    logo: "images/stella_coffee_logo.jpg",
                    url: "",
                },
                {
                    name: "XYZ Coffee Roasters",
                    logo: "images/stella_coffee_logo.jpg",
                    url: "",
                },
                {
                    name: "XYZ Coffee Roasters",
                    logo: "images/stella_coffee_logo.jpg",
                    url: "",
                },
            ]
        }
    }
})
</script>
<style>

.swiper-container {
    overflow: visible;
    padding-bottom: 15px;
}

.swiper-pagination {
    position: absolute;
    bottom: -7px !important;
    padding-left: 20px;
    text-align: left;
    transition: 300ms opacity;
    transform: translate3d(0, 0, 0);
    z-index: 10;
}
</style>

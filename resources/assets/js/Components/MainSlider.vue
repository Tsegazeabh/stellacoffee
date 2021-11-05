<template>
    <div id="main-slider" class="swiper">
        <swiper
            :modules="modules"
            :slides-per-view="1"
            :space-between="50"
            effect="cards"
            autoplay
            navigation
            :parallax="true"
            :pagination="{ clickable: true }"
            :scrollbar="{ draggable: true }">
            <swiper-slide v-for="content in contents">
                <slider-card :content="content">
                </slider-card>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
import {Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
import {Swiper, SwiperSlide} from 'swiper/vue';
import SliderCard from "@components/SliderCard";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';

export default {
    name: "MainSlider",
    components: {SliderCard, Swiper, SwiperSlide},
    setup() {
        return {
            modules: [Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
            parallaxSwiperWidth: 0,
            contents: [
                {
                    title: 'Stella Coffee Brands',
                    lead_paragraph: 'Coffee Shop is the place where you can get flavorful coffee strains from global elite brands and roasters at very affordable price.',
                    image:'http://127.0.0.1:8000/images/bg-image-3.jpg'
                },
                {
                    title: 'Get the Most Out of Your Favorite Roasted Coffee',
                    lead_paragraph: 'AWDA Pvt. Ltd. Co. was established in 1997 G.C with the objective of procurement, processing and export of best Ethiopian Arabica coffees to the entire world.  It is the continuation of the shareholders effort, in the coffee sector where he has been investing and expanding the realm of the company.',
                    image:'http://127.0.0.1:8000/images/bg-image-4.jpg'
                },
                {
                    title: 'Get the Most Out of Your Favorite Coffee',
                    lead_paragraph: 'Coffee Shop is the place where you can get flavorful coffee strains from global elite brands and roasters at very affordable price.',
                    image:'http://127.0.0.1:8000/images/Ampersand-38.jpg'
                },
            ],
        };
    },
}
</script>

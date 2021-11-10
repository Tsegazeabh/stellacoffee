<template>
    <div id="testimonial-slider">
        <div class="slider-header">
            <index-header class="h2 justify-center text-center" title="Testimonials"></index-header>
        </div>
        <div class="swiper-container">
            <swiper
                :modules="modules"
                :space-between="50"
                autoplay
                :breakpoints="swiperOptions.breakpoints"
                :parallax="true"
                :pagination="swiperOptions.pagination"
                :navigation="false">
                <swiper-slide v-for="testimonial in testimonials">
                    <testimonial-card :testimonial="testimonial">
                    </testimonial-card>
                </swiper-slide>
            </swiper>
            <div class="swiper-pagination testimonial-pagination"></div>
        </div>
    </div>
</template>

<script>
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
import TestimonialCard from "@components/TestimonialCard";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import IndexHeader from "./IndexHeader";
import {defineComponent} from 'vue'

export default defineComponent({
    name: "testimonials-slider",
    components: {IndexHeader, TestimonialCard, Swiper, SwiperSlide},
    setup() {
        return {
            modules: [Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
            parallaxSwiperWidth: 0,
            swiperOptions: {

                pagination: {
                    el: '.testimonial-pagination',
                    clickable: true,
                    renderBullet: function (index, className) {
                        console.log(className);
                        return '<span class="' + className + '">' + index + '</span>';
                    },
                },
                breakpoints: {
                    799: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    800: {
                        slidesPerView: 2,
                        spaceBetween: 30
                    }
                }
            },
            testimonials: [
                {
                    testimonial_name: 'Kate Anderson',
                    testimonial_position: 'Artist',
                    testimonial_quote: 'I dropped by to have a cappuccino and honestly, after 30 days here we did not have high expectations. But if this cappuccino was served in Rome, I would be just as satisfied! Great place with perfectly normal prices that I recommend!',
                },
                {
                    testimonial_name: 'Kate Anderson',
                    testimonial_position: 'Artist',
                    testimonial_quote: 'I dropped by to have a cappuccino and honestly, after 30 days here we did not have high expectations. But if this cappuccino was served in Rome, I would be just as satisfied! Great place with perfectly normal prices that I recommend!',
                },
                {
                    testimonial_name: 'Kate Anderson',
                    testimonial_position: 'Artist',
                    testimonial_quote: 'I dropped by to have a cappuccino and honestly, after 30 days here we did not have high expectations. But if this cappuccino was served in Rome, I would be just as satisfied! Great place with perfectly normal prices that I recommend!',
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

<template>
    <div id="testimonial-slider">
        <h2 class="index-header h1 justify-center text-center">Testimonials</h2>
        <div class="swiper">
            <swiper
                :modules="modules"
                :space-between="50"
                autoplay
                :breakpoints="swiperOptions.breakpoints"
                :pagination="{ clickable: true }"
                :parallax="true"
                :navigation="false">
                <swiper-slide v-for="testimonial in testimonials">
                    <testimonial-card :testimonial="testimonial">
                    </testimonial-card>
                </swiper-slide>
            </swiper>
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

export default {
    name: "testimonials-slider",
    components: {TestimonialCard, Swiper, SwiperSlide},
    setup() {
        return {
            modules: [Navigation, Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
            parallaxSwiperWidth: 0,
            swiperOptions: {
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
}
</script>

<style scoped>
.swiper-pagination {
    position: absolute;
    text-align: center;
    transition: 300ms opacity;
    transform: translate3d(0, 0, 0);
    z-index: 10;
}
swiper-horizontal>.swiper-pagination-bullets, .swiper-pagination-bullets.swiper-pagination-horizontal, .swiper-pagination-custom, .swiper-pagination-fraction{

    bottom: -105px !important;
}
</style>

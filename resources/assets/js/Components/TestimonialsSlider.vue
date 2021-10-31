<template>
    <div id="testimonial-slider" class="swiper">
        <swiper
            :modules="modules"
            :slides-per-view="3"
            :space-between="50"
            autoplay
            :parallax="true"
            :pagination="{ clickable: true }">
            <swiper-slide v-for="testimonial in testimonials">
                <testimonial-card :testimonial="testimonial">
                </testimonial-card>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
import {Swiper, SwiperSlide} from 'swiper/vue';
import { Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
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
            modules: [Pagination, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
            parallaxSwiperWidth: 0,
            testimonials: [
                {
                    testimonial_name:'Kate Anderson',
                    testimonial_position:'Artist',
                    testimonial_quote:'I dropped by to have a cappuccino and honestly, after 30 days here we did not have high expectations. But if this cappuccino was served in Rome, I would be just as satisfied! Great place with perfectly normal prices that I recommend!',
                },
                {
                    testimonial_name:'Kate Anderson',
                    testimonial_position:'Artist',
                    testimonial_quote:'I dropped by to have a cappuccino and honestly, after 30 days here we did not have high expectations. But if this cappuccino was served in Rome, I would be just as satisfied! Great place with perfectly normal prices that I recommend!',
                },
                {
                    testimonial_name:'Kate Anderson',
                    testimonial_position:'Artist',
                    testimonial_quote:'I dropped by to have a cappuccino and honestly, after 30 days here we did not have high expectations. But if this cappuccino was served in Rome, I would be just as satisfied! Great place with perfectly normal prices that I recommend!',
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>

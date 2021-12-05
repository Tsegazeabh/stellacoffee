<template>
    <div v-if="mainSliders.length > 0" id="main-slider" class="swiper">
        <swiper
            :modules="modules"
            :slides-per-view="1"
            :space-between="50"
            effect="cards"
            autoplay
            navigation
            :parallax="true"
            :scrollbar="{ draggable: true }">
            <swiper-slide v-for="content in mainSliders">
                <slider-card :content="content">
                </slider-card>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
import {Navigation, Scrollbar, A11y, Autoplay, Parallax, EffectCards} from 'swiper';
import {Swiper, SwiperSlide} from 'swiper/vue';
import SliderCard from "@components/SliderCard";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import 'swiper/css/autoplay';
import {defineComponent} from 'vue';
import axios from "axios";

export default defineComponent({
    name: "MainSlider",
    components: {SliderCard, Swiper, SwiperSlide},
    data() {
        return {
            modules: [Navigation, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
            parallaxSwiperWidth: 0,
            mainSliders: [],
        }
    },
    // setup() {
    //     return {
    //         modules: [Navigation, Scrollbar, A11y, Autoplay, Parallax, EffectCards],
    //         parallaxSwiperWidth: 0,
            // contents: [
            //     {
            //         title: 'Stella Coffee Brands',
            //         lead_paragraph: 'Coffee Shop is the place where you can get flavorful coffee strains from global elite brands and roasters at very affordable price.',
            //         image: 'http://127.0.0.1:8000/images/bg-image-3.jpg'
            //     },
            //     {
            //         title: 'Get the Most Out of Your Favorite Coffee',
            //         lead_paragraph: 'Coffee Shop is the place where you can get flavorful coffee strains from global elite brands and roasters at very affordable price.',
            //         image: 'http://127.0.0.1:8000/images/bg-image-4.jpg'
            //     },
            //     {
            //         title: 'Get the Most Out of Your Favorite Coffee',
            //         lead_paragraph: 'Coffee Shop is the place where you can get flavorful coffee strains from global elite brands and roasters at very affordable price.',
            //         image: 'http://127.0.0.1:8000/images/Ampersand-38.jpg'
            //     },
            // ],
    //     };
    // },
    created() {
        this.fetchMainSliders();
    },
    methods: {
        fetchMainSliders() {
            axios
                .get(route('latest-main-slider'))
                .then((res) => {
                    this.mainSliders = res.data;
                    this.mainSliders = this.mainSliders.map(p => {
                        return p.contentable.src_sets.map(
                            s => {
                                return {
                                    'id': p.id,
                                    'srcset': s,
                                    'title': p.contentable.title,
                                    'description': p.contentable.lead_paragraph,
                                    'first_media': p.contentable.first_media,
                                    'url':p.url
                                }
                            })
                    }).flat();
                    console.log(this.mainSliders);
                })
                .catch(err => this.mainSliders = []);
        }
        // setControlledSwiper(swiper) {
        //     this.controlledSwiper = swiper;
        // },
        // formatDate(date) {
        //     return moment(String(date)).format('MMM DD, YYYY')
        // },
    }
})
</script>

<style>

#main-slider .swiper-button-next, #main-slider .swiper-button-prev {
    right: 0px !important;
    left: auto !important;
    @apply bg-stella text-white p-8 bg-opacity-70 font-black;

}

#main-slider .swiper-button-next {
    top: 61% !important;
}

#main-slider .swiper-button-prev {
    top: 70% !important;
}

#main-slider .swiper-button-prev:after {
    content: '\f060' !important;
    font-family: 'Font Awesome 5 Free' !important;
    font-weight: 900 !important;
}

#main-slider .swiper-button-next:after {
    content: '\f061' !important;
    font-family: 'Font Awesome 5 Free' !important;
    font-weight: 900 !important;
}

#main-slider .swiper-button-next:after, #main-slider .swiper-button-prev:after {
    font-size: 18px !important;
}
</style>

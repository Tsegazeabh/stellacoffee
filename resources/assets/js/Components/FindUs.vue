<template>
    <div id="find-us">
        <div class="flex flex-row flex-wrap w-full justify-center">
            <index-header class="h2 text-center" title="Find Us"></index-header>
        </div>
        <div class="flex flex-row w-full h-full gap-4">
            <div class="md:w-2/5 pl-5">
                <div class="grid grid-cols-2 gap-12">
                    <div class="col-span-1">
                        <h2 class="header">Our Working Hours</h2>
                        <ul>
                            <li class="my-4">
                                <h3 class="font-black text-roast-dark text-xl">Monday until Friday</h3>
                                <p>8:30 AM - 6:00 PM</p>
                            </li>
                            <li class="my-4">
                                <h3 class="font-black text-roast-dark text-xl">Saturday</h3>
                                <p>8:30 AM - 12:30 PM</p>
                            </li>
                            <li class="my-4">
                                <h3 class="font-black text-roast-dark text-xl">Sunday</h3>
                                <p>Closed</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-1">
                        <h2 class="header">Our Shops</h2>
                        <ul>
                            <li v-for="shop in shops" class="my-4">
                                <p>{{ shop.contentable.title }}</p>
                                <p>{{ shop.contentable.shop_address }}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-2">
                        <r-s-s-subscriber-form></r-s-s-subscriber-form>

                    </div>
                </div>
            </div>
            <div class="md:w-3/5">
                <div id='map' class="flex flex-wrap w-full h-full" ref="mapRef"></div>
            </div>
        </div>
    </div>
</template>

<script>
import IndexHeader from "./IndexHeader";
import {defineComponent, ref, onMounted} from 'vue'
import axios from "axios";
import RSSSubscriberForm from "./RSSSubscriberForm";
// import tt from '@tomtom-international/web-sdk-maps'
export default defineComponent({
    name: "find-us",
    components: {RSSSubscriberForm, IndexHeader},

    setup() {

        const tt = window.tt;
        const mapRef = ref(null);
        const shops = ref([])

        const fetchShops = (map) => {
            axios.get(route('fetch-all-shops')).then(
                (res) => {
                    shops.value = res.data
                    shops.value.forEach(function (store) {
                        addMarker(map, store)
                    });
                })
        }

        const addMarker = (map, shop) => {
            let location = [shop.contentable.longitude, shop.contentable.latitude];
            let popupOffset = 25;

            let marker = new tt.Marker().setLngLat(location).addTo(map);
            let popup = new tt.Popup({offset: popupOffset}).setHTML(shop.contentable.title);
            marker.setPopup(popup).togglePopup();
        }

        const subscribe = async () => {
        }

        onMounted(async () => {

            const center = [30, 31];

            let map = tt.map({
                key: 'nntrhdaZESDJDwqAdtfGQL0uQfBA7w09',
                container: mapRef.value,
                center: center,
                zoom: 0.85,
                style: 'tomtom://vector/1/basic-main',
            });

            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());
            await fetchShops(map)
        })

        return {
            mapRef,
            shops,
            subscribe
        };
    }
})
</script>

<!--<style src="@tomtom-international/web-sdk-maps/dist/maps.css"></style>-->

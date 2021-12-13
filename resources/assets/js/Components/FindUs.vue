<template>
    <div id="find-us">
        <index-header class="h2 justify-center text-center" title="Find Us"></index-header>
        <div id='map' ref="mapRef"></div>
    </div>
</template>

<script>
import IndexHeader from "./IndexHeader";
import {defineComponent, ref, onMounted} from 'vue'
import axios from "axios";
import tt from '@tomtom-international/web-sdk-maps';

export default defineComponent({
    name: "find-us",
    components: {IndexHeader},
    setup() {

        const mapRef = ref(null);
        const stores = ref([])

        const fetchStores = () => {
            axios.get(route('fetch-all-stores')).then(
                (res) => {
                    stores.value = res.data
                    stores.value.forEach(function (store) {
                        addMarker(map, store)
                    });
                })
        }

        const addMarker = (map, store) => {
            let location = [store.contentable.latitude, store.contentable.longitude];
            let popupOffset = 25;

            let marker = new tt.Marker().setLngLat(location).addTo(map);
            let popup = new tt.Popup({offset: popupOffset}).setHTML(store.contentable.title);
            marker.setPopup(popup).togglePopup();
        }

        onMounted(async () => {

            const HQ = {lat: 38.769574526646196, lng: 9.0022360310794}

            let map = tt.map({
                key: 'nntrhdaZESDJDwqAdtfGQL0uQfBA7w09',
                container: mapRef.value,
                center: HQ,
                zoom: 15,
                style: 'tomtom://vector/1/basic-main',
            });

            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());
            await fetchStores()
        })

        return {
            mapRef,
            stores
        };
    }
})
</script>
<style>
#map {
    height: 50vh;
    width: 50vw;
}
</style>

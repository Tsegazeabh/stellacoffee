<template>
    <a :href="partner.url" class="partner-card">
        <img :src="partner.logo" class="object-fill"/>
    </a>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    name: "PartnerCard",
    props: {
        partner: {
            type: Object,
            required: true
        }
    }
})
</script>

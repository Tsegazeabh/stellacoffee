<template>
    <a :href="partner.contentable.link" class="partner-card">
          <img :src="partner.contentable.first_media['base64svg']" :srcset="partner.contentable.src_sets.join(' ')"
                 class="object-fill" :alt="partner.contentable.title"/>
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

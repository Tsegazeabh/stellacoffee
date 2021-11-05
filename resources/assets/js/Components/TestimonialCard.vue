<template>
    <div class="testimonial-card">
        <div class="testimonial-info">
            <div class="testimonial-picture">&nbsp;</div>
            <div class="testimonial-profile">
                <p class="testimonial-name">
                    {{ testimonial.testimonial_name }}
                </p>
                <p class="testimonial-position">
                    {{ testimonial.testimonial_position }}
                </p>
            </div>
        </div>
        <blockquote class="testimonial-quote">
            <span class="fas fa-angle-up"></span>
            <p class="my-4">
                <i class="fas fa-quote-left"></i>
            </p>
            <p>
                {{ testimonial.testimonial_quote }}
            </p>
        </blockquote>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "testimonial-card",
    props: {
        testimonial: {
            type: Object,
            required: true
        }
    }
})
</script>

<style scoped>

</style>

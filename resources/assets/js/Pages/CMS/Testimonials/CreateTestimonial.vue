<template>
    <div class="breadcrump">
        <ul>
            <li>
                <inertia-link :href="route('home')">{{ _trans('menu.Home') }}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('dashboard')">{{ _trans('menu.CMS') }}</inertia-link>
            </li>
            <li>
                <inertia-link :href="route('testimonials-management-page')">
                    {{ _trans('label.shared.Customer Testimonials') }}
                </inertia-link>
            </li>
            <li>{{ _trans('action.create') }}</li>
        </ul>
    </div>
    <testimonial-form :customer_testimonial="customer_testimonial"
                           :errors="errors"
                           :method="'post'"
                           :url="route('post-testimonial')">
    </testimonial-form>
</template>

<script>
import {defineComponent} from "vue";
import AdminLayout from "@layouts/AdminLayout";
import TestimonialForm from "../../../Components/Forms/TestimonialForm";

export default defineComponent({
    name: "create-testimonial",
    components: {TestimonialForm},
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout,
    props: {
        customer_testimonial: {
            type: Object,
            default: {
                testimonial_name: '',
                testimonial_organization: '',
                testimonial_position:'',
                testimonial_message:'',
                testimonial_date: '',
                tags: [],
            }
        }
    },
})
</script>

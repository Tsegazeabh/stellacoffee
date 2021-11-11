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
                <inertia-link :href="route('contact-us-request-management-page')">
                    {{ _trans('label.shared.Contact Us Requests') }}
                </inertia-link>
            </li>
            <li>{{ _trans('label.shared.Request Details') }}</li>
        </ul>
    </div>
    <div class="w-full" v-if="contact_us_request">
        <h1 class="header1"><strong>{{ _trans('label.user.full name') }}</strong></h1>
        <div class="w-full">
            <div
                class="w-1/2 flex flex-col justify-end items-left content-info text-gray-600 text-base pt-3 mt-3 text-left">
                <div class="pr-2">
                    <i class="fa fa-map-marker font-bold"></i>
                    <span><strong>{{ _trans('label.shared.Contact Request Details') }}: </strong></span>
                    <span
                        class="underline"> {{ contact_us_request.first_name }} {{ contact_us_request.middle_name }} {{ contact_us_request.last_name }} </span>
                </div>
                <div class="pr-2">
                    <i class="fa fa-map-marker font-bold"></i> <span><strong>{{ _trans('label.user.email') }}: </strong></span>
                    <span class="underline"> {{ contact_us_request.email }} </span>
                </div>
<!--                <div class="pr-2">-->
<!--                    <i class="fa fa-map-marker font-bold"></i>-->
<!--                    <span><strong>{{ _trans('label.shared.Company Name') }}: </strong></span>-->
<!--                    <span class="underline"> {{ contact_us_request.company_name }} </span>-->
<!--                </div>-->
<!--                <div class="pr-2">-->
<!--                    <i class="fa fa-map-marker font-bold"></i>-->
<!--                    <span><strong>{{ _trans('label.shared.Professional Area') }}: </strong></span>-->
<!--                    <span class="underline"> {{ contact_us_request.professional_area }} </span>-->
<!--                </div>-->
                <div class="pr-2">
                    <i class="fa fa-map-marker font-bold"></i> <span><strong>{{ _trans('label.user.phone') }}: </strong> </span>
                    <span class="underline"> {{ contact_us_request.phone_number }} </span>
                </div>
                <div class="pr-2">
                    <i class="fa fa-map-marker  font-bold"></i>
                    <span><strong>{{ _trans('label.shared.Country') }}: </strong> </span>
                    <span class="underline"> {{ contact_us_request.country.name }} </span>
                </div>
                <div class="pr-2">
                    <i class="fa fa-map-marker  font-bold"></i>
                    <span><strong>{{ _trans('label.shared.Receive Update') }}: </strong></span>
                    <span class="underline"> {{ contact_us_request.receive_update == false ? 'No' : 'YES' }} </span>
                </div>
                <div class="pr-2">
                    <i class="fa fa-map-marker  font-bold"></i>
                    <span><strong>{{ _trans('label.shared.Created At') }}: </strong></span>
                    <span class="underline"> {{ formatDate(contact_us_request.created_at) }} </span>
                </div>
                <div class="pr-2">
                    <i class="fa fa-map-marker  font-bold"></i>
                    <span><strong>{{ _trans('label.shared.Status') }}: </strong></span>
                    <span class="underline"> {{ contact_us_request.status == true ? 'Open' : 'Closed' }} </span>
                </div>
            </div>
            <div class="pr-2 w-full">
                <i class="fa fa-map-marker  font-bold"></i>
                <span><strong>{{ _trans('label.shared.Comment Provided') }}: </strong></span>
                <div v-html="contact_us_request.detail" class="text-justify border p-2"></div>
            </div>
        </div>
    </div>
</template>

<script>
//import {defineAsyncComponent, provide} from 'vue'
import moment from 'moment'
import AdminLayout from "../../../Layouts/AdminLayout"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "contact-us-request-detail",
    layout: (h, page) => h(AdminLayout, [page]), // if you want to use different persistence layout
    props: {
        contact_us_request: {
            type: Object,
            required: true,
            default: {}
        }
    },
    methods: {
        formatDate(date) {
            return moment(String(date)).format('MMM DD, YYYY')
        },
    }
})
</script>

<template>
    <ContactUsRequestForm
        :contact_details="contact_details"
        :error-message="errorMessage"
        :success-message="successMessage"
        :errors="errors"
        :method="'post'"
        :url="route('post-contact-us-request')">
    </ContactUsRequestForm>
</template>
<script>
import ContentsLayout from "@layouts/ContentsLayout"
import ContactUsRequestForm from "@components/ContactUsRequestForm"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateContactUsRequest",
    components: {ContactUsRequestForm},
    layout: (h, page) => h(ContentsLayout, [page]), // if you want to use different persistence layout
    props: {
        contact_details: {
            type: Object,
            default: {
                first_name: '',
                middle_name: '',
                last_name: '',
                email: '',
                company_name: '',
                professional_area: '',
                phone_number: '',
                country_id: '',
                detail: '',
                receive_update: false
            }
        },
        errors: {type: Object, default: {}},
        errorMessage: {type: String, default: ''},
        successMessage: {type: String, default: ''}
    },

})
</script>

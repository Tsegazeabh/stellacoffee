<template>
    <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{ errorMessage }}</p>
    <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{ successMessage }}</p>
    <h1 class="text-center header1">{{ _trans('label.shared.Let’s Start a Communication') }}</h1>
    <h2>
        <strong>
            {{ _trans('label.shared.Note') }}:
            {{ _trans('label.shared.Please fill the form and send us your message') }}
        </strong>
<!--        <span>-->
<!--            <inertia-link type="button" :href="route('faq-index')"-->
<!--                          class="no-underline hover:underline text-blue-500 text-lg">-->
<!--                {{ _trans('label.shared.FAQ') }}-->
<!--            </inertia-link>-->
<!--        </span>-->
        <!--TODO -->
    </h2>
    <div class="w-full">
        <div class="container mx-auto py-8 ">
            <div class="w-auto mx-auto bg-white">
                <div class="mx-8 py-4 text-black text-xl font-bold border-b border-grey-500">
                    {{ _trans('label.shared.Contact Us Form') }}
                </div>
                <form @submit.prevent="save">
                    <div class="py-4 px-8 w-full flex flex-wrap">
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.user.first name') }}
                                </label>
                                <input type="text " v-model.trim.lazy="form.first_name"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['first_name'])?'error':''"
                                       :placeholder="_trans('label.user.first name')" autocomplete="on" required/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['first_name']">
                                    {{ form.errors['first_name'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.user.middle name') }}
                                </label>
                                <input type="text" v-model.trim.lazy="form.middle_name"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['middle_name'])?'error':''"
                                       :placeholder="_trans('label.user.middle name')" autocomplete="on" required/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['middle_name']">
                                    {{ form.errors['middle_name'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.user.last name') }}
                                </label>
                                <input type="text" v-model.trim.lazy="form.last_name"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['last_name'])?'error':''"
                                       :placeholder="_trans('label.user.last name')" autocomplete="on" required/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['last_name']">
                                    {{ form.errors['last_name'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.user.email') }}
                                </label>
                                <input type="text" v-model.trim.lazy="form.email"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['email'])?'error':''"
                                       :placeholder="_trans('label.user.email')" autocomplete="on" required/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['email']">
                                    {{ form.errors['email'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.shared.Country') }}
                                </label>
                                <select type="text" v-model.lazy="form.country_id"
                                        class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                                        :class="(form.errors && form.errors['country_id'])?'error':''" required>
                                    <option value="" selected>
                                        {{ _trans('label.shared.Select Country') }}
                                    </option>
                                    <option v-for="(coun,id) in countries" :key="id" :value="id">
                                        {{ coun }}
                                    </option>
                                </select>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['country_id']">
                                    {{ form.errors['country_id'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.user.phone') }}
                                </label>
                                <input type="text" v-model.trim.lazy="form.phone_number"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['phone_number'])?'error':''"
                                       :placeholder="_trans('label.user.phone')" autocomplete="on" required/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['phone_number']">
                                    {{ form.errors['phone_number'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.shared.Company Name') }}
                                </label>
                                <input type="text" v-model.trim.lazy="form.company_name"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['company_name'])?'error':''"
                                       :placeholder="_trans('label.shared.Company Name')" autocomplete="on"/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['company_name']">
                                    {{ form.errors['company_name'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full md:w-1/2">
                            <div class="form-group w-full px-5">
                                <label class="label block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.shared.Professional Area') }}
                                </label>
                                <input type="text" v-model.trim.lazy="form.professional_area"
                                       class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                       :class="(form.errors && form.errors['professional_area'])?'error':''"
                                       :placeholder="_trans('label.shared.Professional Area')" autocomplete="on"/>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['professional_area']">
                                    {{ form.errors['professional_area'] }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-4 w-full">
                            <div class="form-group w-full px-5">
                                <label class="label required block text-grey-darker text-sm font-bold mb-2">
                                    {{ _trans('label.shared.Comment') }}
                                </label>
                                <textarea v-model.trim.lazy="form.detail"
                                          class="form-control w-full border border-gray-100 p-1.5 focus:outline-none border rounded w-full py-2 px-3 text-grey-darker"
                                          :class="(form.errors && form.errors['detail'])?'error':''"
                                          rows="10"
                                          :placeholder="_trans('label.shared.Comment')"
                                          autocomplete="on">
                                </textarea>
                                <span class="text-red-500 font-semibold mt-3"
                                      v-if="form.errors && form.errors['detail']">
                                    {{ form.errors['detail'] }}
                                </span>
                            </div>
                        </div>
                        <div class="w-full my-5 px-5">
                            <input type="checkbox" :class="(form.errors && form.errors['receive_update'])?'error':''"
                                   v-model.lazy="form.receive_update" required>
                            <span class="required">
                        &nbsp;      {{ _trans('label.shared.I understand and agree to the EEU') }}
                                <inertia-link class="no-underline hover:underline text-blue-500 text-lg"
                                              :href="route('privacy-policy-detail')"> {{ _trans('label.shared.Privacy Policy') }} </inertia-link>
                                <span>&nbsp;{{ _trans('label.shared.And') }}&nbsp;</span>
                                <inertia-link class="no-underline hover:underline text-blue-500 text-lg"
                                              :href="route('term-and-condition-detail')"> &nbsp;{{ _trans('label.shared.Terms and Conditions') }}</inertia-link>
                            </span>

                            <span class="text-red-500 font-semibold mt-3"
                                  v-if="form.errors && form.errors['receive_update']">
                                {{ form.errors['receive_update'] }}
                            </span>
                        </div>
                        <div class="w-full my-5 text-right">
                            <button type="submit"
                                    class="border bg-gray-600 rounded-full px-10 py-2 text-white text-base">
                                {{ _trans('label.shared.Send Message') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import Button from "@components/Button";
import {useForm} from '@inertiajs/inertia-vue3';
import Input from "./Input";
import axios from 'axios';
import {defineComponent} from 'vue'

export default defineComponent({
    components: {
        Input,
        Button

    },
    name: "contact-us-request-form",
    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        contact_us_request: {
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
                receive_update: false,
                locale_id: 2
            }
        },
        errors: {
            type: Object,
            default: {}
        },
        errorMessage: {
            type: String,
            default: ''
        },
        successMessage: {
            type: String,
            default: ''
        }
    },
    mounted() {
        this.loadCountries();
    },

    emits: ['submit'],

    data() {
        return {
            countries: [],
            form: useForm({
                first_name: '',
                middle_name: '',
                last_name: '',
                email: '',
                company_name: '',
                professional_area: '',
                phone_number: '',
                country_id: '',
                detail: '',
                receive_update: false,
                locale_id: 2
            }),
        }
    },

    methods: {
        save() {
            this.form.submit(this.method, this.url, {
                onSuccess: (page) => {

                    if (Object.keys(page.props.errors).length == 0) {
                        this.$toast.success('Contact Us Request is sent successfully!')
                        this.form.errors = [];
                        this.form.reset();
                    } else {
                        this.form.errors = page.props.errors;
                    }
                }
            });
        },
        loadCountries() {
            axios.get(route('get-all-countries')).then(response => {
                this.countries = response.data;
            }).catch(e => {
                this.countries = [];
            })
        },

    }
})
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

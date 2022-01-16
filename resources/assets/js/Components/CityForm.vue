<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{errorMessage}}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{successMessage}}</p>
        <form @submit.prevent="save">
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Country')}}</label>
                        <select type="text"
                                v-model.lazy="form.country_id"
                                @change="loadCountries"
                                class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                                :class="(form.errors && form.errors['country_id'])?'error':''" required>
                            <option v-for="(name,id) in countryTypes" :key="id" :value="id">
                                {{name }}
                            </option>
                        </select>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['country_id']">
                            {{form.errors['country_id']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">City(EN)</label>
                        <input type="text" v-model.trim.lazy="form.name"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name'])?'error':''"
                               placeholder="city" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['name']">
                            {{form.errors['name']}}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">ከተማ (አማ)</label>
                        <input type="text" v-model.trim.lazy="form.name_am"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name_am'])?'error':''"
                               placeholder="ከተማ" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['name_am']">
                            {{form.errors['name_am']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">Ville(Fr)</label>
                        <input type="text" v-model.trim.lazy="form.name_fr"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name_fr'])?'error':''"
                               placeholder="ville" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['name_fr']">
                            {{form.errors['name_fr']}}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">Città(IT)</label>
                        <input type="text" v-model.trim.lazy="form.name_it"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name_it'])?'error':''"
                               placeholder="Città" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['name_it']">
                            {{form.errors['name_it']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">City Description(EN)</label>
                        <input type="text" v-model.trim.lazy="form.description"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description'])?'error':''"
                               placeholder="description" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['description']">
                            {{form.errors['description']}}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">የከተማው መግለጫ(አማ)</label>
                        <input type="text" v-model.trim.lazy="form.description_am"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description_am'])?'error':''"
                               placeholder="መግለጫ" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['description_am']">
                            {{form.errors['description_am']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">Descriptif de la ville(FR)</label>
                        <input type="text" v-model.trim.lazy="form.description_fr"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description_fr'])?'error':''"
                               placeholder="Descriptif" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['description_fr']">
                            {{form.errors['description_fr']}}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">Descrizione della città(IT)</label>
                        <input type="text" v-model.trim.lazy="form.description_it"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description_it'])?'error':''"
                               placeholder="descrizione" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['description_it']">
                            {{form.errors['description_lan']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full my-5 text-right">
                <button type="submit" class="border bg-gray-600 rounded-full px-10 py-2 text-white text-base">
                    {{_trans('action.save')}}
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import Button from "@components/Button"
    import {useForm} from '@inertiajs/inertia-vue3'
    import axios from 'axios'

    export default {
        components: {
            Button,
        },
        name: "city-form",

        props: {
            method: {type: String, default: 'post'},
            url: {type: String, required: true},
            city: {
                type: Object,
                default: {
                    name: '',
                    country_id:'',
                    description: '',
                    name_am: '',
                    description_am: '',
                    name_fr: '',
                    description_fr: '',
                    name_it: '',
                    description_it: ''
                }
            },
            countries: {
                type: Object,
                required: true
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
        emits: ['submit'],
        data() {
            return {
                countryTypes: [],
                form: useForm({
                    name: '',
                    country_id:'',
                    description: '',
                    name_am: '',
                    description_am: '',
                    name_fr: '',
                    description_fr: '',
                    name_it: '',
                    description_it: ''
                }),
            }
        },

        mounted() {
            if (this.city) {
                this.form.name = this.city.name
                this.form.country_id = this.city.country_id
                this.form.description = this.city.description
                this.form.name_am= this.city.name_am
                this.form.description_am = this.city.description_am
                this.form.name_fr = this.city.name_fr
                this.form.description_fr = this.city.description_fr
                this.form.name_it = this.city.name_it
                this.form.description_it = this.city.description_it
            }
            this.loadCountries()
        },

        methods: {
            save() {
                // Validate CKEditor input  for XSS attack
                this.form.submit(this.method, this.url, {
                    onSuccess: (page) => {
                        if (Object.keys(page.props.errors).length == 0) {
                            if (this.method.toLowerCase() == 'put') {
                                this.$toast.success('City updated successfully!')
                            } else {
                                this.$toast.success('City is created successfully!')
                            }
                            this.form.errors = [];
                            this.form.reset();
                        } else {
                            this.form.errors = page.props.errors;
                        }
                    }
                })
            },

            loadCountries() {
                axios.get(route('fetch-countries')).then(response => {
                    this.countryTypes = response.data;
                }).catch(e => {
                    this.countryTypes = [];
                })
            },
        }
    }
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

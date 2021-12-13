<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{errorMessage}}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{successMessage}}</p>
        <form @submit.prevent="save">
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">Service Type(EN)</label>
                        <input type="text" v-model.trim.lazy="form.name"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name'])?'is-invalid':''"
                               placeholder="Service Type" autocomplete="on" required/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['name']">
                            {{ form.errors['name'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">Description(EN)</label>
                        <input type="text" v-model.trim.lazy="form.description"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description'])?'is-invalid':''"
                               placeholder="Description" autocomplete="on"/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['description']">
                            {{ form.errors['description'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">የአገልግሎት ዓይነት(አማ)</label>
                        <input type="text" v-model.trim.lazy="form.name_am"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name_am'])?'is-invalid':''"
                               placeholder="የአገልግሎት ዓይነት" autocomplete="on" required/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['name_am']">
                            {{ form.errors['name_am'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">መግለጫ(አማ)</label>
                        <input type="text" v-model.trim.lazy="form.description_am"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description_am'])?'is-invalid':''"
                               placeholder="መግለጫ" autocomplete="on"/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['description_am']">
                            {{ form.errors['description_am'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">Type De Service(FR)</label>
                        <input type="text" v-model.trim.lazy="form.name_fr"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name_fr'])?'is-invalid':''"
                               placeholder="Type De Service" autocomplete="on" required/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['name_fr']">
                            {{ form.errors['name_fr'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">La Description(FR)</label>
                        <input type="text" v-model.trim.lazy="form.description_fr"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description_fr'])?'is-invalid':''"
                               placeholder="La Description" autocomplete="on"/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['description_fr']">
                            {{ form.errors['description_fr'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">Tipo Di Servizio(IT)</label>
                        <input type="text" v-model.trim.lazy="form.name_it"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['name_it'])?'is-invalid':''"
                               placeholder="Tipo Di Servizio" autocomplete="on" required/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['name_it']">
                            {{ form.errors['name_it'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">Descrizione(IT)</label>
                        <input type="text" v-model.trim.lazy="form.description_it"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['description_it'])?'is-invalid':''"
                               placeholder="Descrizione" autocomplete="on"/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['description_it']">
                            {{ form.errors['description_it'] }}
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

    export default {
        components: {
            Button,
        },
        name: "service-type-form",

        props: {
            method: {type: String, default: 'post'},
            url: {type: String, required: true},
            service_type: {
                type: Object,
                default: {
                    name: '',
                    name_am: '',
                    name_fr: '',
                    name_it: '',
                    description: '',
                    description_am: '',
                    description_fr: '',
                    description_it: ''
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

        emits: ['submit'],

        data() {
            return {
                form: useForm({
                    name: '',
                    name_am: '',
                    name_fr: '',
                    name_it: '',
                    description: '',
                    description_am: '',
                    description_fr: '',
                    description_it: ''
                }),
            }
        },

        mounted() {
            if (this.service_type) {
                this.form.name = this.service_type.name
                this.form.name_am = this.service_type.name_am
                this.form.name_fr = this.service_type.name_fr
                this.form.name_it = this.service_type.name_it
                this.form.description = this.service_type.description
                this.form.description_am = this.service_type.description_am
                this.form.description_fr = this.service_type.description_fr
                this.form.description_it = this.service_type.description_it
            }
        },

        methods: {
            save() {
                // Validate CKEditor input  for XSS attack
                this.form.submit(this.method, this.url, {
                    onSuccess: (page) => {
                        if (Object.keys(page.props.errors).length==0) {
                            if(this.method.toLowerCase()=='put') {
                                this.$toast.success('Service Type is updated successfully!')
                            }
                            else {
                                this.$toast.success('Service Type is created successfully!')
                            }
                            this.form.errors = [];
                            this.form.reset();
                        } else {
                            this.form.errors = page.props.errors;
                        }
                    }
                });
            },
        }
    }
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

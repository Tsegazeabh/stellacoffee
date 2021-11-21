<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{errorMessage}}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{successMessage}}</p>
        <form @submit.prevent="save">
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Partner Name')}}</label>
                        <input type="text" v-model.trim.lazy="form.title"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['title'])?'is-invalid':''"
                               :placeholder="_trans('label.shared.Partner Name')" autocomplete="on" required />
                        <span class="invalid-feedback" v-if="form.errors && form.errors['title']">
                            {{ form.errors['title'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{_trans('label.shared.Tags')}}</label>
                        <tags-selector v-model="form.tags"></tags-selector>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Partner Logo/Brand')}}</label>
                        <input type="file" @input="prepareForUpload"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['attachments'])?'is-invalid':''"
                               :placeholder="_trans('label.shared.Partner Logo/Brand')"/>
                            <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['attachments']">
                                {{form.errors['attachments'] }}
                            </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Official Link')}}</label>
                        <input type="url" v-model.lazy="form.link"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['link'])?'is-invalid':''"
                               placeholder="https://stellacoffee.com" autocomplete="on" required />
                        <span class="invalid-feedback" v-if="form.errors && form.errors['link']">
                            {{ form.errors['link'] }}
                        </span>
                    </div>
                </div>

            </div>
            <div class="w-full my-5 px-5">
                <label class="label inline-block"><strong>{{_trans('label.shared.Description')}}</strong></label>
                <ck-editor :editor="editor"
                           class="border border-gray-100"
                           v-model.lazy="form.detail"
                           :editorConfig="editorConfig"
                           @ready="onEditorReady">
                </ck-editor>
                <span class="invalid-feedback" v-if="form.errors && form.errors['detail']">
                          {{ form.errors['detail'] }}
                </span>
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
    import EEUClassicEditor from "@components/EEUClassicEditor";
    //import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    import CKEditor from "@ckeditor/ckeditor5-vue"
    import Button from "@components/Button"
    import {useForm} from '@inertiajs/inertia-vue3'
    import TagsSelector from "@components/TagsSelector";

    export default {
        components: {
            TagsSelector,
            Button,
            'ck-editor': CKEditor.component
        },
        name: "partner-form",

        props: {
            isEdit:{
                type: Boolean,
                default: false
            },
            method: {type: String, default: 'post'},
            url: {type: String, required: true},
            partner: {
                type: Object,
                default: {
                    title: '',
                    tags: [],
                    detail: '',
                    link:'',
                    attachments:''
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
                editor: EEUClassicEditor,
                editorData: '',
                editorConfig: {
                    height: '500px'
                },
                form: useForm({
                    title: '',
                    tags: [],
                    link:'',
                    attachments:''
                }),

            }
        },

        mounted() {
            if (this.partner) {
                this.form.title = this.partner.title
                this.form.link = this.partner.link
            }

            if (this.partner && this.partner.content && this.partner.content.tags) {
                this.form.tags = this.partner.content.tags
            } else if (this.partner && this.partner.content) {
                this.form.tags = []
            }
        },

        methods: {
            onEditorReady(editor){
                editor.ui.getEditableElement().parentElement.insertBefore(
                    editor.ui.view.toolbar.element,
                    editor.ui.getEditableElement()
                );
                if (this.partner) {
                    this.form.detail = this.partner.detail
                }
            },
            save() {
                if(this.form.tags==undefined || this.form.tags==null) this.form.tags=[];
                if(this.form.attachments==undefined || this.form.attachments==null) this.form.attachments='';
                // Validate CKEditor input  for XSS attack
                this.form.submit(this.method, this.url, {
                    onSuccess: (page) => {
                        if (Object.keys(page.props.errors).length == 0) {
                            if (this.isEdit) {
                                this.$toast.success('Partner is updated successfully!')
                            } else {
                                this.$toast.success('Partner is created successfully!')
                            }
                            this.form.errors = [];
                            this.form.reset();
                        } else {
                            this.form.errors = page.props.errors;
                        }
                    }
                });
            },
            prepareForUpload(event) {
                this.form.attachments = event.target.files[0]
            },

        }
    }
</script>

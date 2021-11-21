<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{errorMessage}}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{successMessage}}</p>
        <form @submit.prevent="save">
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Slider Title')}}</label>
                        <input type="text" v-model.trim.lazy="form.title"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['title'])?'error':''"
                               :placeholder="_trans('label.shared.Slider Title')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['title']">
                            {{form.errors['title']}}
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
                        <label class="label required">{{_trans('label.shared.Slider Image')}}</label>
                        <input type="file" @input="prepareForUpload"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['attachments'])?'error':''"
                               :placeholder="_trans('label.shared.Attachments')"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['attachments']">
                            {{form.errors['attachments']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full my-5 px-5">
                <label class="label inline-block"><strong>{{_trans('label.shared.Slider Description')}}</strong></label>
                <ck-editor :editor="editor"
                           class="border border-gray-100"
                           :class="(form.errors && form.errors['detail'])?'error':''"
                           v-model.lazy="form.detail"
                           :editorConfig="editorConfig"
                           @ready="onEditorReady">
                </ck-editor>
                <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['detail']">
                    {{form.errors['detail']}}
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
    import EEUClassicEditor from "@components/EEUClassicEditor"
    import CKEditor from "@ckeditor/ckeditor5-vue"
    import Button from "@components/Button"
    import {useForm} from '@inertiajs/inertia-vue3'
    import TagsSelector from "@components/TagsSelector"

    export default {
        components: {
            TagsSelector,
            Button,
            'ck-editor': CKEditor.component
        },
        name: "main-slider-form",

        props: {
            isEdit: {
                type: Boolean,
                default: false
            },
            method: {type: String, default: 'post'},
            url: {type: String, required: true},
            main_slider: {
                type: Object,
                default: {
                    title: '',
                    tags: [],
                    detail: '',
                    attachments: ''
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
                    detail: '',
                    link: '',
                    attachments: ''
                }),

            }
        },

        mounted() {
            if (this.main_slider) {
                this.form.title = this.main_slider.title
                this.form.link = this.main_slider.link
            }

            if (this.main_slider && this.main_slider.content && this.main_slider.content.tags) {
                this.form.tags = this.main_slider.content.tags
            } else if (this.main_slider && this.main_slider.content) {
                this.form.tags = []
            }
        },

        methods: {
            onEditorReady(editor) {
                editor.ui.getEditableElement().parentElement.insertBefore(
                    editor.ui.view.toolbar.element,
                    editor.ui.getEditableElement()
                );
                if (this.main_slider) {
                    this.form.detail = this.main_slider.detail
                }
            },
            save() {
                if (this.form.tags == undefined || this.form.tags == null) this.form.tags = [];
                if (this.form.attachments == undefined || this.form.attachments == null) this.form.attachments = '';
                // Validate CKEditor input  for XSS attack
                this.form.submit(this.method, this.url, {
                    onSuccess: (page) => {
                        if (Object.keys(page.props.errors).length == 0) {
                            if (this.isEdit) {
                                this.$toast.success('Main Slider is updated successfully!')
                            } else {
                                this.$toast.success('Main Slider is created successfully!')
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

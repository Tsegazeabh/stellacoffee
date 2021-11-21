<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{errorMessage}}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{successMessage}}</p>
        <form @submit.prevent="save">
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Title')}}</label>
                        <input type="text" v-model.trim.lazy="form.title"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['title'])?'is-invalid':''"
                               :placeholder="_trans('label.shared.Title')" autocomplete="on" required/>
                        <span class="invalid-feedback" v-if="form.errors && form.errors['title']">
                            {{ form.errors['title'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full my-5 px-5">
                <label class="label required inline-block">{{_trans('label.shared.Detail')}}</label>
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
    import EEUClassicEditor from "@components/EEUClassicEditor"
    import CKEditor from "@ckeditor/ckeditor5-vue"
    import Button from "@components/Button"
    import {useForm} from '@inertiajs/inertia-vue3'
    import TagsSelector from "@components/TagsSelector"

    export default {
        components: {
            TagsSelector,
            Button,
            'ck-editor': CKEditor.component,
        },
        name: "term-and-condition-form",
        props: {
            method: {type: String, default: 'post'},
            url: {type: String, required: true},
            term_and_condition: {
                type: Object,
                default: {
                    title: '',
                    tags: [],
                    detail: ''
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
                    height: '500px',

                },
                form: useForm({
                    title: '',
                    detail: ''
                }),
            }
        },

        mounted() {
            if (this.term_and_condition) {
                this.form.title = this.term_and_condition.title
            }
        },
        methods: {
            onEditorReady(editor) {
                editor.ui.getEditableElement().parentElement.insertBefore(
                    editor.ui.view.toolbar.element,
                    editor.ui.getEditableElement()
                );
                if (this.term_and_condition) {
                    this.form.detail = this.term_and_condition.detail
                }
            },
            save() {
                // Validate CKEditor input  for XSS attack
                this.form.submit(this.method, this.url, {
                    onSuccess: (page) => {
                        if (Object.keys(page.props.errors).length==0) {
                            if(this.method.toLowerCase()=='put') {
                                this.$toast.success('Privacy Policy updated successfully!')
                            }
                            else {
                                this.$toast.success('Privacy Policy is created successfully!')
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

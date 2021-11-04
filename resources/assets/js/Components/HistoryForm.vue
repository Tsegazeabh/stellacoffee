<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{errorMessage}}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{successMessage}}</p>
        <form @submit.prevent="save">
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.From')}}</label>
                        <date-picker v-model="form.from_date" mode="date" is24hr :is-required="true">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                                    :class="(form.errors && form.errors['from_date'])?'error':''"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['from_date']">
                            {{form.errors['from_date']}}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.To')}}</label>
                        <date-picker class="w-full" v-model="form.to_date" mode="date" is24hr :is-required="true">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                                    :class="(form.errors && form.errors['to_date'])?'error':''"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['to_date']">
                            {{form.errors['to_date']}}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Title')}}</label>
                        <input type="text" v-model.trim.lazy="form.title"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['title'])?'error':''"
                               :placeholder="_trans('label.shared.Title')" autocomplete="on" required/>
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
            <div class="w-full my-5 px-5">
                <label class="label required inline-block">{{_trans('label.shared.Description')}}</label>
                <ck-editor :editor="editor"
                           class="border border-gray-100"
                           v-model.lazy="form.detail"
                           :class="(form.errors && form.errors['detail'])?'error':''"
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
    import EEUClassicEditor from "@components/EEUClassicEditor";
    import CKEditor from "@ckeditor/ckeditor5-vue"
    import Button from "@components/Button"
    import {useForm} from '@inertiajs/inertia-vue3'
    import TagsSelector from "@components/TagsSelector";
    import {DatePicker} from 'v-calendar';
    import moment from "moment";

    export default {
        components: {
            TagsSelector,
            Button,
            'ck-editor': CKEditor.component,
            'date-picker': DatePicker
        },
        name: "history-form",

        props: {
            method: {type: String, default: 'post'},
            url: {type: String, required: true},
            history: {
                type: Object,
                default: {
                    from_date: '',
                    to_date: '',
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
                    from_date: '',
                    to_date: '',
                    title: '',
                    tags: [],
                    detail: ''
                }),
            }
        },

        mounted() {
            if (this.history) {
                this.form.title = this.history.title
                this.form.from_date = this.history.from_date
                this.form.to_date = this.history.to_date
            }
            if (this.history && this.history.content && this.history.content.tags) {
                this.form.tags = this.history.content.tags
            } else if (this.history && this.history.content) {
                this.form.tags = []
            }
        },
        methods: {
            onEditorReady(editor) {
                editor.ui.getEditableElement().parentElement.insertBefore(
                    editor.ui.view.toolbar.element,
                    editor.ui.getEditableElement()
                );
                if (this.history) {
                    this.form.detail = this.history.detail
                }
            },
            save() {
                this.form.from_date = moment(this.form.from_date).format('YYYY-MM-DD');
                this.form.to_date = moment(this.form.to_date).format('YYYY-MM-DD');
                if (this.form.tags == undefined || this.form.tags == null) this.form.tags = []
                // Validate CKEditor input  for XSS attack
                this.form.submit(this.method, this.url, {
                    onSuccess: (page) => {
                        if (Object.keys(page.props.errors).length == 0) {
                            if (this.method.toLowerCase() == 'put') {
                                this.$toast.success('History is updated successfully!')
                            } else {
                                this.$toast.success('History is created successfully!')
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

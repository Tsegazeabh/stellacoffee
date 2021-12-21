<template>
    <div class="flex flex-col w-full">
        <p v-if="errorMessage && errorMessage.length>0" class="shadow-lg text-red-500">{{ errorMessage }}</p>
        <p v-if="successMessage && successMessage.length>0" class="shadow-lg text-success-500">{{ successMessage }}</p>
        <form @submit.prevent="save">
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Title') }}</label>
                        <input type="text" v-model.trim.lazy="form.title"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['title'])?'error':''"
                               :placeholder="_trans('label.shared.Title')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['title']">
                            {{ form.errors['title'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Certificate Provider') }}</label>
                        <input type="text" v-model.trim.lazy="form.provider"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['provider'])?'error':''"
                               :placeholder="_trans('label.shared.Certificate Provider')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['provider']">
                            {{ form.errors['provider'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Certification Date') }}</label>
                        <date-picker class="w-full"
                                     v-model="form.provided_date"
                                     mode="date"
                                     :model-config="dateTimePickerConfig"
                                     :is-required="true">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                                    :class="(form.errors && form.errors['provided_date'])?'error':''"
                                    :placeholder="_trans('label.shared.Certification Date')"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                    required
                                />
                            </template>
                        </date-picker>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['provided_date']">
                            {{ form.errors['provided_date'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Tags') }}</label>
                        <tags-selector v-model="form.tags"></tags-selector>
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Video Link') }}</label>
                        <input type="text" v-model.trim.lazy="form.video_link"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['video_link'])?'error':''"
                               :placeholder="_trans('label.shared.Video Link')" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['video_link']">
                            {{ form.errors['video_link'] }}
                        </span>
                    </div>
                </div>


                <div class="w-full md:w-1/2 flex">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Attachment') }}</label>
                        <input type="file"
                               @input="prepareForUpload"
                               multiple
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['attachment'])?'is-invalid':''"
                               :placeholder="_trans('label.shared.Attachment')"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['attachment']">
                            {{ form.errors['attachment'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full my-5 px-5">
                <label class="label required inline-block">{{ _trans('label.shared.Description') }}</label>
                <ck-editor :editor="editor"
                           class="border border-gray-100"
                           v-model.lazy="form.detail"
                           :class="(form.errors && form.errors['detail'])?'error':''"
                           :editorConfig="editorConfig"
                           @ready="onEditorReady">
                </ck-editor>
                <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['detail']">
                    {{ form.errors['detail'] }}
                </span>
            </div>

            <div class="w-full my-5 text-right">
                <button type="submit" class="border bg-gray-600 rounded-full px-10 py-2 text-white text-base">
                    {{ _trans('action.save') }}
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
    name: "CertificationForm",

    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        certification: {
            type: Object,
            default: {
                title: '',
                detail: '',
                provided_date: '',
                provider: '',
                video_link: '',
                tags: [],
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
            dateTimePickerConfig: {
                type: 'string',
                mask: 'YYYY-MM-DD', // Uses 'iso' if missing
            },
            form: useForm({
                title: '',
                detail: '',
                provided_date: '',
                provider: '',
                video_link: '',
                attachment: null,
                tags: [],
            }),
        }
    },

    mounted() {
        if (this.certification) {
            this.form.title = this.certification.title
            this.form.video_link = this.certification.video_link
            this.form.provided_date = this.certification.provided_date
            this.form.provider = this.certification.provider
        }
        if (this.certification && this.certification.content && this.certification.content.tags) {
            this.form.tags = this.certification.content.tags
        } else if (this.certification && this.certification.content) {
            this.form.tags = []
        }
    },
    methods: {
        onEditorReady(editor) {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
            if (this.certification) {
                this.form.detail = this.certification.detail
            }
        },

        prepareForUpload(event) {
            this.form.attachment = event.target.files[0]
        },

        save() {
            if (this.form.tags == undefined || this.form.tags == null) this.form.tags = []
            if (this.form.attachment == undefined || this.form.attachment == null) this.form.attachment = ''
            this.form.submit(this.method, this.url, {
                onSuccess: (page) => {
                    if (Object.keys(page.props.errors).length == 0) {
                        if (this.certification.id) {
                            this.$toast.success('Certification is updated successfully!')
                        } else {
                            this.$toast.success('Certification is created successfully!')
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

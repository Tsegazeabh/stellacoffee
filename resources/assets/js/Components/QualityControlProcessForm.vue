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
                        <label class="label">{{ _trans('label.shared.Tags') }}</label>
                        <tags-selector v-model="form.tags"></tags-selector>
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Stage') }}</label>
                        <input type="text" v-model.trim.lazy="form.stage"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['stage'])?'error':''"
                               :placeholder="_trans('label.shared.Stage')" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['stage']">
                            {{ form.errors['stage'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Youtube URL') }}</label>
                        <input type="text" v-model.trim.lazy="form.video_link"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['video_link'])?'error':''"
                               :placeholder="_trans('label.shared.Youtube URL')" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['video_link']">
                            {{ form.errors['video_link'] }}
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
import {defineComponent} from 'vue'

export default defineComponent({
    components: {
        TagsSelector,
        Button,
        'ck-editor': CKEditor.component,
        'date-picker': DatePicker
    },
    name: "QualityControlProcessForm",
    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        quality_control_process: {
            type: Object,
            default: {
                title: '',
                detail: '',
                stage: '',
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
            form: useForm({
                title: '',
                detail: '',
                stage: '',
                video_link: '',
                tags: [],
            }),
        }
    },

    mounted() {
        if (this.quality_control_process) {
            this.form.title = this.quality_control_process.title
            this.form.video_link = this.quality_control_process.video_link
            this.form.stage = this.quality_control_process.stage
        }
        if (this.quality_control_process && this.quality_control_process.content && this.quality_control_process.content.tags) {
            this.form.tags = this.quality_control_process.content.tags
        } else if (this.quality_control_process && this.quality_control_process.content) {
            this.form.tags = []
        }
    },
    methods: {
        onEditorReady(editor) {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
            if (this.quality_control_process) {
                this.form.detail = this.quality_control_process.detail
            }
        },
        save() {
            if (this.form.tags == undefined || this.form.tags == null) this.form.tags = []
            // Validate CKEditor input  for XSS attack
            this.form.submit(this.method, this.url, {
                onSuccess: (page) => {
                    if (Object.keys(page.props.errors).length == 0) {
                        if (this.method.toLowerCase() == 'put') {
                            this.$toast.success('Quality Control Process is updated successfully!')
                        } else {
                            this.$toast.success('Quality Control Process is created successfully!')
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
})
</script>

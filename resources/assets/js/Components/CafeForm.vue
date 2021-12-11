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
                        <label class="label required">{{ _trans('label.shared.Size') }}</label>
                        <input type="text" v-model.trim.lazy="form.size"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['size'])?'error':''"
                               :placeholder="_trans('label.shared.Size')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['size']">
                            {{ form.errors['size'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{_trans('label.shared.Service Type')}}</label>
                        <select type="text" v-model.lazy="form.service_type_id"
                                class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                                :class="(form.errors && form.errors['service_type_id'])?'error':''" required>
                            <option v-for="(name,id) in service_types" :key="id" :value="id">
                                {{name }}
                            </option>
                        </select>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['service_type_id']">
                            {{form.errors['service_type_id']}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Price') }}</label>
                        <input type="text" v-model.trim.lazy="form.price"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['price'])?'error':''"
                               :placeholder="_trans('label.shared.Price')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['price']">
                            {{ form.errors['price'] }}
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
                        <label class="label required">{{_trans('label.shared.Service Image')}}</label>
                        <input type="file" @input="prepareForUpload"
                               class="form-control w-full border border-gray-100 p-1.5 focus:outline-none"
                               :class="(form.errors && form.errors['attachments'])?'error':''"
                               :placeholder="_trans('label.shared.Service Image')"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['attachments']">
                            {{form.errors['attachments']}}
                        </span>
                    </div>
                </div>
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
    name: "CafeForm",
    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        cafe: {
            type: Object,
            default: {
                title: '',
                service_type_id: '',
                size:'',
                price:'',
                attachments:'',
                detail: '',
                video_link: '',
                tags: [],
            }
        },
        service_types:{
            type: Object,
            required:true
        },
        isEdit:{
            type: Boolean,
            default: false
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
                service_type_id: '',
                size:'',
                price:'',
                attachments:'',
                detail: '',
                video_link: '',
                tags: [],
            }),
        }
    },

    mounted() {
        if (this.cafe) {
            this.form.title = this.cafe.title
            this.form.size = this.cafe.size
            this.form.price = this.cafe.price
            this.form.video_link = this.cafe.video_link
        }
        if (this.cafe && this.cafe.content && this.cafe.content.tags) {
            this.form.tags = this.cafe.content.tags
        } else if (this.cafe && this.cafe.content) {
            this.form.tags = []
        }
    },
    methods: {
        onEditorReady(editor) {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
            if (this.cafe) {
                this.form.detail = this.cafe.detail
            }
        },
        save() {
            if (this.form.tags == undefined || this.form.tags == null) this.form.tags = [];
            if (this.form.attachments == undefined || this.form.attachments == null) this.form.attachments = '';
            // Validate CKEditor input  for XSS attack
            this.form.submit(this.method, this.url, {
                onSuccess: (page) => {
                    if (Object.keys(page.props.errors).length == 0) {
                        if (this.method.toLowerCase() == 'put') {
                            this.$toast.success('Cafe Service Type is updated successfully!')
                        } else {
                            this.$toast.success('Cafe Service Type is created successfully!')
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
})
</script>

<template>
    <div class="flex flex-col w-full">
        <form @submit.prevent="save">
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Testimonial Name') }}</label>
                        <input type="text" v-model.trim.lazy="form.testimonial_name"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['testimonial_name'])?'error':''"
                               :placeholder="_trans('label.shared.Testimonial Name')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['testimonial_name']">
                            {{ form.errors['testimonial_name'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Testimonial Organization') }}</label>
                        <input type="text" v-model.trim.lazy="form.testimonial_organization"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['testimonial_organization'])?'error':''"
                               :placeholder="_trans('label.shared.Testimonial Organization')" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['testimonial_organization']">
                            {{ form.errors['testimonial_organization'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Testimonial Position') }}</label>
                        <input type="text" v-model.trim.lazy="form.testimonial_position"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['testimonial_position'])?'error':''"
                               :placeholder="_trans('label.shared.Testimonial Position')"
                               autocomplete="on"
                               required/>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['testimonial_position']">
                            {{ form.errors['testimonial_position'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Testimonial Date') }}</label>
                        <date-picker class="w-full"
                                     v-model="form.testimonial_date"
                                     mode="date"
                                     :model-config="dateTimePickerConfig"
                                     :is-required="true">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                                    :class="(form.errors && form.errors['testimonial_date'])?'error':''"
                                    :placeholder="_trans('label.shared.Testimonial Date')"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                    required
                                />
                            </template>
                        </date-picker>
                        <span class="text-red-500 font-semibold mt-3"
                              v-if="form.errors && form.errors['testimonial_date']">
                            {{ form.errors['testimonial_date'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Tags') }}</label>
                        <tags-selector v-model="form.tags"></tags-selector>
                    </div>
                </div>

                <div class="w-full my-5 px-5">
                    <label class="label required inline-block">{{ _trans('label.shared.Testimonial Message') }}</label>
                    <ck-editor :editor="editor"
                               class="border border-gray-100"
                               v-model.lazy="form.testimonial_message"
                               :class="(form.errors && form.errors['testimonial_message'])?'error':''"
                               :editorConfig="editorConfig"
                               @ready="onEditorReady">
                    </ck-editor>
                    <span class="text-red-500 font-semibold mt-3"
                          v-if="form.errors && form.errors['testimonial_message']">
                        {{ form.errors['testimonial_message'] }}
                    </span>
                </div>

                <div class="w-full my-5 text-right">
                    <button type="submit" class="border bg-gray-600 rounded-full px-10 py-2 text-white text-base">
                        {{ _trans('action.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>

import {defineComponent, ref, onMounted} from "vue";
import CKEditor from "@ckeditor/ckeditor5-vue";
import {DatePicker} from "v-calendar";
import TagsSelector from "@components/TagsSelector";
import EEUClassicEditor from "@components/EEUClassicEditor";
import {useForm} from "@inertiajs/inertia-vue3";
import moment from "moment";

export default defineComponent({
    name: "testimonial-form",
    components: {
        TagsSelector,
        'ck-editor': CKEditor.component,
        'date-picker': DatePicker
    },

    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        customer_testimonial: {
            type: Object,
            default: {
                testimonial_name: '',
                testimonial_organization: '',
                testimonial_position: '',
                testimonial_message: '',
                testimonial_date: '',
                tags: [],
            }
        }
    },

    emits: ['submit'],

    setup(props, context) {

        const form = ref(useForm({
            testimonial_name: '',
            testimonial_organization: '',
            testimonial_position: '',
            testimonial_message: '',
            testimonial_date: '',
            tags: [],
        }));

        const onEditorReady = (editor) => {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
            if (props.customer_testimonial) {
                form.value.testimonial_message = props.customer_testimonial.testimonial_message
            }
        };

        const save = async () => {
            if (form.value.tags == undefined || form.value.tags == null) form.value.tags = []

            form.value.submit(props.method, props.url, {
                onSuccess: (page) => {
                    if (Object.keys(page.props.errors).length == 0) {
                        if (props.method.toLowerCase() == 'put') {
                            $toast.success('Testimonial is updated successfully!')
                        } else {
                            $toast.success('Testimonial is created successfully!')
                        }
                        form.value.errors = [];
                        form.value.reset();
                    } else {
                        form.value.errors = page.props.errors;
                    }
                }
            });
        }

        onMounted(async () => {
            if (props.customer_testimonial) {
                form.value.testimonial_name = props.customer_testimonial.testimonial_name
                form.value.testimonial_organization = props.customer_testimonial.testimonial_organization
                form.value.testimonial_position = props.customer_testimonial.testimonial_position
                form.value.testimonial_date = moment(props.customer_testimonial.testimonial_date, "YYYY-MM-DD").format("YYYY-MM-DD")

                if (props.customer_testimonial.content && props.customer_testimonial.content.tags) {
                    form.value.tags = props.customer_testimonial.content.tags
                } else if (props.customer_testimonial.content) {
                    form.value.tags = []
                }
            }

        });

        return {
            dateTimePickerConfig: {
                type: 'string',
                mask: 'YYYY-MM-DD', // Uses 'iso' if missing
            },
            editor: EEUClassicEditor,
            editorData: '',
            editorConfig: {height: '500px'},
            form,
            onEditorReady,
            save
        };
    }
})
</script>

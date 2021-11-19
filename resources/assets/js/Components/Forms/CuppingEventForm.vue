<template>
    <div class="flex flex-col w-full">
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
                        <label class="label">{{ _trans('label.shared.Event Place') }}</label>
                        <input type="text" v-model.trim.lazy="form.event_place"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['event_place'])?'error':''"
                               :placeholder="_trans('label.shared.Event Place')" autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['event_place']">
                            {{ form.errors['event_place'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Event Date') }}</label>
                        <date-picker class="w-full"
                                     v-model="form.event_date"
                                     mode="dateTime"
                                     :model-config="dateTimePickerConfig"
                                     :is-required="false">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                                    :class="(form.errors && form.errors['event_date'])?'error':''"
                                    :placeholder="_trans('label.shared.Event Date')"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                />
                            </template>
                        </date-picker>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['event_date']">
                            {{ form.errors['event_date'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Tags') }}</label>
                        <tags-selector v-model="form.tags"></tags-selector>
                    </div>
                </div>

                <div class="w-full">
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
            </div>
        </form>
    </div>
</template>

<script>
import {defineComponent, ref, toRefs, onMounted} from "vue";
import CKEditor from "@ckeditor/ckeditor5-vue";
import {DatePicker} from "v-calendar";
import TagsSelector from "@components/TagsSelector";
import EEUClassicEditor from "@components/EEUClassicEditor";
import {useForm} from "@inertiajs/inertia-vue3";
import moment from "moment";

export default defineComponent({
    name: "cupping-event-form",
    components: {
        TagsSelector,
        'ck-editor': CKEditor.component,
        'date-picker': DatePicker
    },

    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        cupping_event: {
            type: Object,
            default: {
                title: '',
                detail: '',
                event_place:'',
                event_date:'',
                video_link: '',
                tags: [],
            }
        }
    },

    emits: ['submit'],

    setup(props, context) {
        const form = ref(useForm({
            title: '',
            detail: '',
            event_place:'',
            event_date:'',
            video_link: '',
            tags: [],
        }));

        const onEditorReady = (editor) => {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
            if (props.cupping_event) {
                form.value.detail = props.cupping_event.detail
            }
        };

        const save = async () => {
            if (form.value.tags == undefined || form.value.tags == null) form.value.tags = []

            form.value.submit(props.method, props.url, {
                onSuccess: (page) => {
                    if (Object.keys(page.props.errors).length == 0) {
                        if (props.method.toLowerCase() == 'put') {
                            $toast.success('Cupping event is updated successfully!')
                        } else {
                            $toast.success('Cupping event is created successfully!')
                        }
                        form.value.errors = [];
                        form.value.reset();
                    } else {
                        form.value.errors = page.props.errors;
                    }
                }
            });
        }

        onMounted(() => {
            if (props.cupping_event) {
                form.value.title = props.cupping_event.title
                form.value.event_place = props.cupping_event.event_place
                form.value.event_date = moment(props.cupping_event.event_date, "YYYY-MM-DD hh:mm").format("YYYY-MM-DD hh:mm a")
                form.value.video_link = props.cupping_event.video_link
            }
            if (props.cupping_event && props.cupping_event.content && props.cupping_event.content.tags) {
                form.value.tags = props.cupping_event.content.tags
            } else if (props.cupping_event && props.cupping_event.content) {
                form.value.tags = []
            }
        });
        return {
            dateTimePickerConfig: {
                type: 'string',
                mask: 'YYYY-MM-DD h:mm A', // Uses 'iso' if missing
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

<template>
    <div class="flex flex-col w-full">
        <form @submit.prevent="save">
            <div class="w-full flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Country') }}</label>
                        <select v-model.trim.lazy="form.country_id"
                                class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                                :class="(form.errors && form.errors['country_id'])?'error':''"
                                :placeholder="_trans('label.shared.Country')"
                                required>
                            <option value="">Select country</option>
                            <option v-for="(name,id) in countries" :key="id" :value="id">
                                {{ name }}
                            </option>
                        </select>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['country_id']">
                            {{ form.errors['country_id'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Airport Name') }}</label>
                        <input type="text" v-model.trim.lazy="form.airport_name"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['airport_name'])?'error':''"
                               :placeholder="_trans('label.shared.Airport Name')" autocomplete="on"
                               required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['airport_name']">
                            {{ form.errors['airport_name'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Shop Address') }}</label>
                        <input type="text" v-model.trim.lazy="form.shop_address"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['shop_address'])?'error':''"
                               :placeholder="_trans('label.shared.Shop Address')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['shop_address']">
                            {{ form.errors['shop_address'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label required">{{ _trans('label.shared.Name') }}</label>
                        <input type="text" v-model.trim.lazy="form.title"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['title'])?'error':''"
                               :placeholder="_trans('label.shared.Name')" autocomplete="on" required/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['title']">
                            {{ form.errors['title'] }}
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Longitude') }}</label>
                        <input type="number"
                               v-model.trim.lazy="form.longitude"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['longitude'])?'error':''"
                               :placeholder="_trans('label.shared.Longitude')"
                               autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['longitude']">
                            {{ form.errors['longitude'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Latitude') }}</label>
                        <input type="number"
                               v-model.trim.lazy="form.latitude"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['latitude'])?'error':''"
                               :placeholder="_trans('label.shared.Latitude')"
                               autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['latitude']">
                            {{ form.errors['latitude'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Video Link') }}</label>
                        <input type="text" v-model.trim.lazy="form.video_link"
                               class="form-control w-full border border-gray-100 p-2 focus:outline-none"
                               :class="(form.errors && form.errors['video_link'])?'error':''"
                               :placeholder="_trans('label.shared.Video Link')"
                               autocomplete="on"/>
                        <span class="text-red-500 font-semibold mt-3" v-if="form.errors && form.errors['video_link']">
                            {{ form.errors['video_link'] }}
                        </span>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <div class="form-group w-full px-5">
                        <label class="label">{{ _trans('label.shared.Tags') }}</label>
                        <tags-selector v-model="form.tags"></tags-selector>
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
import {defineComponent, ref, onMounted} from "vue";
import CKEditor from "@ckeditor/ckeditor5-vue";
import {DatePicker} from "v-calendar";
import TagsSelector from "@components/TagsSelector";
import EEUClassicEditor from "@components/EEUClassicEditor";
import {useForm} from "@inertiajs/inertia-vue3";

export default defineComponent({
    name: "duty-free-location-form",
    components: {
        TagsSelector,
        'ck-editor': CKEditor.component,
        'date-picker': DatePicker
    },

    props: {
        method: {type: String, default: 'post'},
        url: {type: String, required: true},
        duty_free_location: {
            type: Object,
            default: {
                country_id: '',
                airport_name:'',
                shop_address:'',
                title: '',
                detail: '',
                longitude: '',
                latitude: '',
                video_link: '',
                tags: [],
            }
        }
    },

    emits: ['submit'],

    setup(props, context) {

        const countries = ref([])

        const form = ref(useForm({
            country_id: '',
            airport_name:'',
            shop_address:'',
            title: '',
            detail: '',
            longitude: '',
            latitude: '',
            video_link: '',
            tags: [],
        }));

        const loadCountries = async () => {
            axios.get(route('fetch-countries'))
                .then((res) => {
                    countries.value = res.data;
                })
                .catch((error) => {
                    countries.value = [];
                    console.log("Unable to load country list.");
                })
        }

        const onEditorReady = (editor) => {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
            if (props.duty_free_location) {
                form.value.detail = props.duty_free_location.detail
            }
        };

        const save = async () => {
            if (form.value.tags == undefined || form.value.tags == null) form.value.tags = []
            form.value.submit(props.method, props.url, {
                onSuccess: (page) => {
                    if (Object.keys(page.props.errors).length == 0) {
                        if (props.method.toLowerCase() == 'put') {
                            $toast.success('Duty free location is updated successfully!')
                        } else {
                            $toast.success('Duty free location is created successfully!')
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
            await loadCountries();
            form.value.title = props.duty_free_location.title
            form.value.airport_name = props.duty_free_location.airport_name
            form.value.shop_address = props.duty_free_location.shop_address
            form.value.country_id = props.duty_free_location.country_id
            form.value.longitude = props.duty_free_location.longitude
            form.value.latitude = props.duty_free_location.latitude
            form.value.video_link = props.duty_free_location.video_link

            if (props.duty_free_location && props.duty_free_location.content && props.duty_free_location.content.tags) {
                form.value.tags = props.duty_free_location.content.tags
            } else if (props.duty_free_location && props.duty_free_location.content) {
                form.value.tags = []
            }
        });

        return {
            editor: EEUClassicEditor,
            editorData: '',
            editorConfig: {height: '500px'},
            countries,
            form,
            save,
            onEditorReady
        };
    }
})
</script>

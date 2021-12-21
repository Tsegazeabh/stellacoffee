<template>
    <div class="flex flex-col justify-start items-start w-full h-full py-4">
        <h3 class="text-base mb-3">{{ _trans('messages.Get upto date information by subscribing to our RSS Channel') }}</h3>
        <form @submit.prevent.stop="subscribe" class="flex flex-row flex-wrap w-full">
            <input type="email"
                   v-model.lazy="email"
                   :placeholder="_trans('label.user.email')"
                   class="form-control border border-blue-500  border-radius-0 flex-grow">
            <button type="submit" class="border bg-blue-700 text-white flex-grow-0 w-max p-3">
                {{ _trans('action.Subscribe') }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios"
import {defineComponent} from 'vue'

export default defineComponent({
    name: "RSSSubscriberForm",
    data() {
        return {
            email: ''
        }
    },
    methods: {
        subscribe() {
            axios
                .post(route('add-subscriber'), {email: this.email})
                .then((_) => {
                        this.$toast.success(this._trans('messages.SuccessfulRSSSubscription'))
                    }
                )
                .catch((error) => {
                    console.log(error.response.data)
                    this.$toast.error(error.response.data)
                })
        }
    }
})
</script>

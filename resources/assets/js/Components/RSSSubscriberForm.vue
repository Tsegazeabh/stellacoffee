<template>
    <div class="flex text-gray-100 bg-gray-600 justify-center items-center w-full h-full p-8">
        <form @submit.prevent.stop="subscribe()">
            <p class="w-full text-2xl mb-4">{{_trans('messages.Get upto date information by subscribing to our RSS Channel')}}</p>
            <input
                class="bg-white w-full border border-black p-2 focus:outline-none text-black"
                type="email"
                v-model.lazy="email"
                :placeholder="_trans('label.user.email')"/>
            <button type="submit"
                class="bg-yellow-600 text-white w-full rounded-full text-2xl px-12 py-3 my-4">
                {{_trans('action.Subscribe')}}
            </button>
        </form>

    </div>
</template>

<script>
    import axios from "axios"

    export default {
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
    }
</script>

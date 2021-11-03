<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Re-send Email Activation Link" @click="resendUserActivationMail">
        <i class="fa fa-envelope"></i>
    </button>
</template>

<script>
    import Button from "@components/Button";
    export default {
        name: "send-user-activation-mail-icon",
        components: {Button},
        data() { return {} },

        mounted() { },

        methods: {
            resendUserActivationMail() {
                this.params.context.componentParent.resendEmailVerfication(this.params.value)
            }
        }
    }
</script>



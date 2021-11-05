<template>
    <button class="p-3.5 text-red-500 flex justify-center items-center" title="Send Password Rest Link" @click="sendPasswordResetLink">
        <i class="fa fa-user-shield"></i>
    </button>
</template>

<script>
    import Button from "@components/Button";
    export default {
        name: "password-reset-icon",
        components: {Button},
        data() { return {} },

        mounted() { },

        methods: {
            sendPasswordResetLink() {
                this.params.context.componentParent.sendPasswordResetLink(this.params.value)
            }
        }
    }
</script>



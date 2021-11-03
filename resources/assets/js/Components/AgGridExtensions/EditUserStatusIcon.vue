<template>
    <button v-if="params.active" type="button" class="p-3.5 text-red-500 flex justify-center items-center" title="Lock User" @click="changeStatus">
        <i class="fa fa-lock"></i>
    </button>

    <button v-else type="button" class="p-3.5 text-red-500 flex justify-center items-center"
            title="Unlock User" @click="changeStatus">
        <i class="fa fa-unlock"></i>
    </button>
</template>

<script>
    export default {
        name: "edit-user-status-icon",

        methods: {
            changeStatus() {
                if(confirm("Are you sure you want to change the status of the user?")) {
                    this.params.context.componentParent.updateUserStatus(this.params.value)
                }
            }
        }
    }
</script>

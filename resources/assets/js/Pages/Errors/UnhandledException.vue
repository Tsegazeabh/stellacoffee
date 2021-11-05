<template>
    <p class="text-red-500 p-5 font-xl font-semibold">{{ errorMessage }}</p>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "unhandled-exception",

    props: {
        errorMessage: {
            type: String,
            default: 'Whoops! something goes wrong please consult system administrator.'
        }
    }
})
</script>



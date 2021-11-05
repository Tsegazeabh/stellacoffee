<template>
    <div class="w-full flex justify-center items-center text-gray-500 h-96">
        <h1 class="text-6xl text-center inline-block border-r p-5 m-5">Oops</h1>
        <div class="inline-block items-center justify-center">
            <h1 class="text-4xl text-center">Database connection exception!</h1>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "QueryException.vue"
})
</script>



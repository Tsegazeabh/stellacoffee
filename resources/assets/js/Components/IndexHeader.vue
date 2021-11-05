<template>
    <h1 class="index-header">
        <span>{{ title }}</span>
        <span>&nbsp;</span>
    </h1>
</template>

<script>
export default {
    name: "IndexHeader",
    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>

</style>

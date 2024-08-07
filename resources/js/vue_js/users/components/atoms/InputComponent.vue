<template>
    <div class="form-group">
        <label :for="id">{{ label }}</label>
        <input :id="id" :type="type" class="form-control" v-model="value" />
    </div>
</template>

<script>
export default {
    props: {
        id: String,
        label: String,
        type: {
            type: String,
            default: "text",
        },
        value: [String, Number],
    },
};
</script>

<style scoped>
/* Custom styles for the input */
</style>

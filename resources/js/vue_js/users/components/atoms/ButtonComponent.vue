<template>
    <button :class="['btn', buttonClass]" @click="handleClick">
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        color: {
            type: String,
            default: "primary",
        },
        size: {
            type: String,
            default: "md",
        },
    },
    computed: {
        buttonClass() {
            return `btn-${this.color} btn-${this.size}`;
        },
    },
    methods: {
        handleClick(event) {
            this.$emit("click", event);
        },
    },
};
</script>

<style scoped>
/* Custom styles for the button */
</style>

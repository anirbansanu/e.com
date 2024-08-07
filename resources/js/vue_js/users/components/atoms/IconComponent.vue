<template>
    <i :class="['icon', iconClass]" :style="{ color: color }"></i>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        size: {
            type: String,
            default: "1x",
        },
        color: {
            type: String,
            default: "#ffd700", // Golden color
        },
    },
    computed: {
        iconClass() {
            return `fa fa-${this.name} fa-${this.size}`;
        },
    },
};
</script>

<style scoped>
.icon {
    font-size: 1.5rem;
}
</style>

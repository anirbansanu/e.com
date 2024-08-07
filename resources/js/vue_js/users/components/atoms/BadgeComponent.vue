<template>
    <span :class="['badge', badgeClass]">
        <slot></slot>
    </span>
</template>

<script>
export default {
    props: {
        color: {
            type: String,
            default: "gold",
        },
    },
    computed: {
        badgeClass() {
            return `badge-${this.color}`;
        },
    },
};
</script>

<style scoped>
.badge {
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 0.2rem;
    padding: 0.35em 0.65em;
}
.badge-gold {
    background-color: #ffd700; /* Golden color */
    color: #000;
}
</style>

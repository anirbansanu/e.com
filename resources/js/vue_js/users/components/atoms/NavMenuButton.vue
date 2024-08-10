<!-- NavMenuButton.vue -->
<template>
    <button
        class="btn btn-light rounded font-weight-bolder mx-2"
        @click="onClick"
    >
        <i :class="icon"></i>
    </button>
</template>

<script>
export default {
    props: {
        icon: String,
        onClick: Function,
    },
};
</script>

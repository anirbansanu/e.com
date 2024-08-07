<template>
    <div class="card">
        <img :src="image" class="card-img-top" alt="Image" />
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ description }}</p>
            <button-component color="gold" @click="handleAction"
                >Shop Now</button-component
            >
        </div>
    </div>
</template>

<script>
import ButtonComponent from "../atoms/ButtonComponent.vue";

export default {
    components: {
        ButtonComponent,
    },
    props: {
        image: String,
        title: String,
        description: String,
    },
    methods: {
        handleAction() {
            this.$emit("action");
        },
    },
};
</script>

<style scoped>
.card {
    border: 1px solid #000;
    background-color: #000;
    color: #ffd700; /* Golden color */
}
.card-img-top {
    height: 200px;
    object-fit: cover;
}
.card-title,
.card-text {
    color: #ffd700; /* Golden color */
}
</style>

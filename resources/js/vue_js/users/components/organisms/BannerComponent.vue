<template>
    <div class="banner">
        <div class="banner-content">
            <h1>{{ title }}</h1>
            <p>{{ subtitle }}</p>
            <button-component color="gold" @click="handleAction">{{
                buttonText
            }}</button-component>
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
        title: String,
        subtitle: String,
        buttonText: {
            type: String,
            default: "Shop Now",
        },
    },
    methods: {
        handleAction() {
            this.$emit("action");
        },
    },
};
</script>

<style scoped>
.banner {
    background: url("@/assets/images/banner.jpg") no-repeat center center;
    background-size: cover;
    color: #fff;
    text-align: center;
    padding: 100px 0;
}
.banner-content {
    background: rgba(0, 0, 0, 0.5);
    display: inline-block;
    padding: 20px;
    border-radius: 10px;
}
.banner h1 {
    font-size: 3rem;
    color: #ffd700; /* Golden color */
}
.banner p {
    font-size: 1.25rem;
    color: #ffd700; /* Golden color */
}
</style>

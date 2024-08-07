<template>
    <main-template>
        <checkout-component />
    </main-template>
</template>

<script>
import MainTemplate from "../templates/MainTemplate.vue";
import CheckoutComponent from "../organisms/CheckoutComponent.vue";

export default {
    components: {
        MainTemplate,
        CheckoutComponent,
    },
};
</script>

<style scoped>
/* Custom styles for the checkout page */
</style>

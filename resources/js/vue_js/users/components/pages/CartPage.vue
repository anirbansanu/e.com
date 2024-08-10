<template>
    <main-template>
        <cart-component
            :cartItems="cartItems"
            :total="total"
            @remove="handleRemove"
            @checkout="handleCheckout"
        />
    </main-template>
</template>

<script>
import MainTemplate from "@/vue_js/users/components/templates/MainTemplate.vue";
import CartComponent from "@/vue_js/users/components/organisms/CartComponent.vue";

export default {
    components: {
        MainTemplate,
        CartComponent,
    },
    data() {
        return {
            cartItems: [], // Fetch or define your cart items here
            total: 0, // Calculate the total
        };
    },
    methods: {
        handleRemove(product) {
            // Handle removing item from cart
        },
        handleCheckout() {
            // Handle checkout
        },
    },
};
</script>

<style scoped>
/* Custom styles for the cart page */
</style>

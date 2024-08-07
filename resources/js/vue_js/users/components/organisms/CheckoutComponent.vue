<template>
    <form class="checkout-form" @submit.prevent="submitOrder">
        <h3>Checkout</h3>
        <input-component id="name" label="Name" v-model="name" />
        <input-component id="address" label="Address" v-model="address" />
        <input-component
            id="payment"
            label="Payment Method"
            v-model="paymentMethod"
        />
        <button-component color="gold" type="submit"
            >Place Order</button-component
        >
    </form>
</template>

<script>
import InputComponent from "../atoms/InputComponent.vue";
import ButtonComponent from "../atoms/ButtonComponent.vue";

export default {
    components: {
        InputComponent,
        ButtonComponent,
    },
    data() {
        return {
            name: "",
            address: "",
            paymentMethod: "",
        };
    },
    methods: {
        submitOrder() {
            // Handle order submission
            console.log("Order submitted:", {
                name: this.name,
                address: this.address,
                paymentMethod: this.paymentMethod,
            });
        },
    },
};
</script>

<style scoped>
.checkout-form {
    max-width: 500px;
    margin: 0 auto;
}
</style>

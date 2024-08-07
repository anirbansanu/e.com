<template>
    <div class="cart">
        <h3>Your Cart</h3>
        <cart-item-component
            v-for="item in cartItems"
            :key="item.id"
            :product="item"
            @remove="removeItem"
        />
        <div class="cart-total">
            <h4>Total: {{ total | currency }}</h4>
            <button-component color="gold" @click="checkout"
                >Checkout</button-component
            >
        </div>
    </div>
</template>

<script>
import CartItemComponent from "../molecules/CartItemComponent.vue";
import ButtonComponent from "../atoms/ButtonComponent.vue";

export default {
    components: {
        CartItemComponent,
        ButtonComponent,
    },
    props: {
        cartItems: Array,
        total: Number,
    },
    methods: {
        removeItem(product) {
            this.$emit("remove", product);
        },
        checkout() {
            this.$emit("checkout");
        },
    },
};
</script>

<style scoped>
.cart {
    padding: 20px;
}
.cart-total {
    margin-top: 20px;
}
</style>

<template>
    <div class="cart-item">
        <img :src="product.image" class="cart-item-img" alt="Product Image" />
        <div class="cart-item-details">
            <h5 class="cart-item-title">{{ product.title }}</h5>
            <p class="cart-item-price">{{ product.price | currency }}</p>
            <button-component color="gold" @click="removeFromCart"
                >Remove</button-component
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
        product: Object,
    },
    methods: {
        removeFromCart() {
            this.$emit("remove", this.product);
        },
    },
};
</script>

<style scoped>
.cart-item {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}
.cart-item-img {
    width: 100px;
    height: auto;
}
.cart-item-details {
    margin-left: 15px;
}
.cart-item-title {
    font-size: 1rem;
    color: #ffd700; /* Golden color */
}
.cart-item-price {
    font-size: 1.25rem;
    color: #ffd700; /* Golden color */
}
</style>

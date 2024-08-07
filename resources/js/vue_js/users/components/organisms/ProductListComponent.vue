<template>
    <div class="product-list">
        <div class="row">
            <div class="col-md-4" v-for="product in products" :key="product.id">
                <card-component
                    :image="product.image"
                    :title="product.title"
                    :description="product.description"
                    @action="handleProductClick(product)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CardComponent from "../molecules/CardComponent.vue";

export default {
    components: {
        CardComponent,
    },
    props: {
        products: Array,
    },
    methods: {
        handleProductClick(product) {
            // Handle product click
            console.log("Product clicked:", product);
        },
    },
};
</script>

<style scoped>
.product-list {
    margin-top: 20px;
}
</style>

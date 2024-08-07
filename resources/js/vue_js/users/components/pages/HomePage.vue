<template>
    <main-template>
        <banner-component
            title="Welcome to Our Premium Clothing"
            subtitle="Elegant attire for every special occasion"
        />
        <product-list-component :products="products" />
    </main-template>
</template>

<script>
import MainTemplate from "../templates/MainTemplate.vue";
import BannerComponent from "../organisms/BannerComponent.vue";
import ProductListComponent from "../organisms/ProductListComponent.vue";

export default {
    components: {
        MainTemplate,
        BannerComponent,
        ProductListComponent,
    },
    data() {
        return {
            products: [], // Fetch or define your products here
        };
    },
};
</script>

<style scoped>
/* Custom styles for the home page */
</style>

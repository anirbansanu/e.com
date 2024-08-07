<template>
    <main>
        <banner-component :title="bannerTitle" :subtitle="bannerSubtitle" />
        <product-list-component :products="products" />
    </main>
</template>

<script>
import BannerComponent from "../organisms/BannerComponent.vue";
import ProductListComponent from "../organisms/ProductListComponent.vue";

export default {
    components: {
        BannerComponent,
        ProductListComponent,
    },
    props: {
        bannerTitle: String,
        bannerSubtitle: String,
        products: Array,
    },
};
</script>

<style scoped>
/* Custom styles for the product template */
</style>

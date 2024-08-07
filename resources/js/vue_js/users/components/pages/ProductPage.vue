<template>
    <main-template>
        <product-template
            :bannerTitle="bannerTitle"
            :bannerSubtitle="bannerSubtitle"
            :products="products"
        />
    </main-template>
</template>

<script>
import MainTemplate from "../templates/MainTemplate.vue";
import ProductTemplate from "../templates/ProductTemplate.vue";

export default {
    components: {
        MainTemplate,
        ProductTemplate,
    },
    data() {
        return {
            bannerTitle: "Featured Products",
            bannerSubtitle: "Discover our exclusive collection",
            products: [], // Fetch or define your products here
        };
    },
};
</script>

<style scoped>
/* Custom styles for the product page */
</style>

<template>
    <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Latest Products
        </h2>
      </div>
      <div class="row">
         <ProductItems
          v-for="(product, index) in products"
          :key="index"
          :product="product"
        />
      </div>
      <div class="btn-box">
        <a href="">
          View All Products
        </a>
      </div>
    </div>
  </section>
</template>

<script>
import ProductItems from './ProductItems.vue'
export default {
     components:{
        ProductItems
    },
    data() {
       return {
          products: [
            { id: 1, name: 'Necklace', price: '$200', image: 'font-end/images/p1.png', isNew: true },
            { id: 2, name: 'Bracelet', price: '$150', image: 'font-end/images/p2.png', isNew: false },
            { id: 3, name: 'Earrings', price: '$100', image: 'font-end/images/p3.png', isNew: true },
            { id: 4, name: 'Ring', price: '$250', image: 'font-end/images/p4.png', isNew: false },
            { id: 5, name: 'Watch', price: '$300', image: 'font-end/images/p5.png', isNew: true },
            { id: 6, name: 'Brooch', price: '$180', image: 'font-end/images/p6.png', isNew: false },
            { id: 7, name: 'Pendant', price: '$220', image: 'font-end/images/p7.png', isNew: true },
            { id: 8, name: 'Cufflinks', price: '$130', image: 'font-end/images/p8.png', isNew: false }
          ]
        };
    },
}
</script>
<!-- PATH = resources/js/vue_js/root.vue -->

<template>
    <div>
        <Header />
        <Slider />
        <LatestProduct />
        <AboutUs />
        <Discounts />
        <Blog />
        <Testimonial />
        <Info />
    </div>
</template>

<script>
import Header from '../components/Header.vue';
import Slider from '../components/Slider.vue';
import LatestProduct from '../components/LatestProduct.vue'
import AboutUs from '../components/AboutUs.vue';
import Discounts from '../components/Discounts.vue'
import Blog from '../components/Blog.vue'
import Testimonial from '../components/Testimonial.vue'
import Info from '../components/Info.vue';
export default {
    name: 'HomePage',
    components:{
        Slider,
        Header,
        LatestProduct,
        AboutUs,
        Discounts,
        Blog,
        Testimonial,
        Info
    },
    mounted() {
    console.log('HomePage component mounted.');
  }
};
</script>

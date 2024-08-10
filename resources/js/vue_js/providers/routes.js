// PATH = resources/js/vue_js/providers/routes.js
import { createRouter, createWebHistory } from 'vue-router';
import Root from '../root.vue';
import HomePage from '../users/pages/HomePage.vue';
import ProductDetails from '../users/components/ProductDetails.vue';
import CartPage from '../users/components/pages/CartPage.vue';

const routes = [

  {
    path: '/',
    name: 'home',
    component: HomePage
  },
  {
    path: '/product-details',
    name: 'productDetails',
    component: ProductDetails
  },
  {
    path: '/cart',
    name: 'cart',
    component: CartPage
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;

<template>
    <!-- <div class="order-lg-last col-lg-5 col-sm-8 col-8">
        <div class="d-flex float-end">
          <a href="https://github.com/mdbootstrap/bootstrap-material-design" class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center" target="_blank"> <i class="fas fa-user-alt m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Sign in</p> </a>
          <a href="https://github.com/mdbootstrap/bootstrap-material-design" class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center" target="_blank"> <i class="fas fa-heart m-1 me-md-2"></i><p class="d-none d-md-block mb-0">Wishlist</p> </a>
          <a href="https://github.com/mdbootstrap/bootstrap-material-design" class="border rounded py-1 px-3 nav-link d-flex align-items-center" target="_blank"> <i class="fas fa-shopping-cart m-1 me-md-2"></i><p class="d-none d-md-block mb-0">My cart</p> </a>
        </div>
    </div> -->
    
    <!-- content -->
    <ProdeuctDetailsItem />
    <section class="bg-light border-top py-4">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <Specification />
                </div>
                <div class="col-lg-4">
                     <SimilerProducts/>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ProdeuctDetailsItem from './ProdeuctDetailsItem.vue'
import SimilerProducts from './SimilerProducts.vue'
import Specification from './Specification.vue'
export default {
    components: {
        ProdeuctDetailsItem,
        SimilerProducts,
        Specification
    },
    data() {
        return {};
    },
};
</script>
<style scoped>
.product-details {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    padding: 20px;
    margin: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-image {
    flex: 1 1 300px;
    padding: 20px;
}

.product-image img {
    max-width: 100%;
    border-radius: 8px;
}

.product-info {
    flex: 2 1 400px;
    padding: 20px;
}

.product-name {
    font-size: 2rem;
    margin: 0 0 10px;
}

.product-price {
    font-size: 1.5rem;
    color: #e74c3c;
    margin: 0 0 20px;
}

.product-description {
    font-size: 1rem;
    line-height: 1.5;
    color: #555;
    margin: 0 0 20px;
}

.add-to-cart {
    padding: 10px 20px;
    font-size: 1rem;
    color: #fff;
    background-color: #e74c3c;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.add-to-cart:hover {
    background-color: #c0392b;
}
</style>

<template>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="box">
            <router-link to='/product-details'>
                <div class="img-box">
                    <img :src="product.image" alt="" />
                </div>
                <div class="detail-box">
                    <h6>{{ product.name }}</h6>
                    <h6>
                        Price
                        <span>{{ product.price }}</span>
                    </h6>
                </div>
                <div class="new" v-if="product.isNew">
                    <span>New</span>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {};
    },
};
</script>

<style>
.box a {
    text-decoration: none;
}
.box h6 {
    font-weight: bold;
}
</style>

<template>
    <header class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container custom_menu d-flex justify-content-between">
                <a class="navbar-brand" href="index.html">
                    <span> Healet </span>
                </a>
                <div class="" id="">
                    <div class="">
                        <div class="">
                            <NavMenuButton
                                icon="fas fa-bars"
                                @click="openNav()"
                            />

                            <router-link to="/cart" class="btn btn-light rounded font-weight-bolder mx-2" >
                                <i class="fas fa-cart-arrow-down"></i>
                            </router-link>

                            <NavMenuButton
                                icon="fas fa-sign-in-alt"
                                @click="loginPage()"
                            />
                        </div>
                        <div id="myNav" class="overlay">
                            <div class="d-flex justify-content-end mt-2">
                                <NavMenuButton
                                    icon="fas fa-times"
                                    @click="openNav()"
                                />
                            </div>

                            <div class="overlay-content">
                                <router-link to="/">Home</router-link>
                                <router-link to="/about">About</router-link>
                                <router-link to="/shop">Shop</router-link>
                                <router-link to="/blog">Blog</router-link>
                                <router-link to="/cart">Cart</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
import NavMenuButton from "../components/atoms/NavMenuButton.vue";
export default {
    components: {
        NavMenuButton,
    },
    methods: {
        openNav() {
            document.getElementById("myNav").classList.toggle("menu_width");
            document
                .querySelector(".custom_menu")
                .classList.toggle("menu_btn-style");
            document.querySelector("body").classList.toggle("no-scroll");
            console.log("openNav called");
        },

    },
};
</script>

<style scoped>
.z-in-3000 {
    z-index: 3000;
}
.overlay {
    background-color: rgba(34, 34, 34, 0.98);
}
.no-scroll {
    overflow: hidden !important;
    scroll-behavior: none !important;
}
</style>

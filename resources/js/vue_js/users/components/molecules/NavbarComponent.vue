<template>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Premium Brand</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <icon-component name="shopping-cart" size="lg" />
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import IconComponent from "../atoms/IconComponent.vue";

export default {
    components: {
        IconComponent,
    },
};
</script>

<style scoped>
.navbar {
    background-color: #000;
}
.navbar-brand,
.nav-link {
    color: #ffd700; /* Golden color */
}
.nav-link {
    margin-right: 20px;
}
</style>

<template>
    <div>
        <navbar-component />
        <main>
            <slot></slot>
        </main>
        <footer-component />
    </div>
</template>

<script>
import NavbarComponent from "../organisms/NavbarComponent.vue";
import FooterComponent from "../organisms/FooterComponent.vue";

export default {
    components: {
        NavbarComponent,
        FooterComponent,
    },
};
</script>

<style scoped>
/* Custom styles for the main template */
</style>

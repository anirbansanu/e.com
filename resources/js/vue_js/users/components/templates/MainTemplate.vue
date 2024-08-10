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
import NavbarComponent from "@/vue_js/users/components/molecules/NavbarComponent.vue";
import FooterComponent from "@/vue_js/users/components/organisms/FooterComponent.vue";

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

<!-- PATH = resources/js/vue_js/root.vue -->

<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'Root',
    mounted() {
    console.log('Root component mounted.');
  }
};
</script>

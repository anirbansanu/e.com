<!-- PATH = resources/js/vue_js/root.vue -->

<template>
    <div>
        <router-view />
    </div>
</template>

<script>
export default {
    name: 'Root',
    components:{
       
    },
    mounted() {
    console.log('Root component mounted.');
  }
};
</script>

<template>
     <section class="blog_section ">
    <div class="container">
      <div class="heading_container">
        <h2>
          Latest From Blog
        </h2>
      </div>
      <div class="row">
         <BlogBoxItem v-for="index in 3" :key="index" />
      </div>
    </div>
  </section>
</template>

<script>

import BlogBoxItem from '../components/BlogBoxItem.vue'
export default {
    components:{
        BlogBoxItem
    },
    data() {
        return{
          
        }
    },
}
</script>
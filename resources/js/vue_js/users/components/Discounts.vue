<template>
    <section class="offer_section layout_padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7 px-0">
                    <DiscountsItem /> 
                </div>
                <div class="col-md-5 px-0">
                    <DiscountsItem /> 
                    <DiscountsItem /> 
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import DiscountsItem from './DiscountsItem.vue'
export default {
    components:{
        DiscountsItem
    },
    data() {
        return{
          
        }
    },
}
</script>
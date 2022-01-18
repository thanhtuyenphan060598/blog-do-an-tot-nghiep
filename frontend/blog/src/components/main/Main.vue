<template>
<div >
<!-- Main -->
 
    <div class="banner py-4" >
      <div class="container">
        <VueSlickCarousel v-bind="settings">
            <div><img src="https://images.viblo.asia/full/bf6fd90b-e818-4cb4-a025-0ffe3f915ef0.png" class="img-fluid" alt="Responsive image"></div>
            <div><img src="https://images.viblo.asia/full/f6e3d256-a4d4-4751-8fc6-895e53f6c74f.jpg" class="img-fluid" alt="Responsive image"></div>
            <div><img src="https://images.viblo.asia/full/688a2cf2-99b3-481c-abbe-16000a16c68b.png" class="img-fluid" alt="Responsive image"></div>
        </VueSlickCarousel>
      </div>
    </div>
  <router-view></router-view>
</div>
</template>
<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
export default {
    data() {
    return {
      settings : {
        arrows:false,
        autoplay : true,
        autoplaySpeed:2000,
        draggable: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        touchThreshold: 1000,
      }
    }
  },
  methods: {

  },
  components : {
    VueSlickCarousel
  },
  mounted() {
    //this.$router.push({name:'listpost'})
  }

}
</script>
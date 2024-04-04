<script setup>
    import HeaderComponent from '../components/HeaderComponent.vue';
    import NavbarComponent from '../components/NavbarComponent.vue';
    import CarouselComponent from '../components/CarouselComponent.vue';
    import AppBarComponent from '../components/AppBarComponent.vue';
    import FooterComponent from '../components/FooterComponent.vue';
    import { useStore } from 'vuex';
    import { computed, ref, onMounted, onUnmounted } from 'vue';
  
    const store = useStore();
    const data = computed(() => store.getters.layoutData);
    const fantomeTop = ref(0);

    const handleScroll = () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop < 500) {
      fantomeTop.value = 0;
    } else {
      fantomeTop.value = -8;
    }
  };
  
    onMounted(() => {
      window.addEventListener('scroll', handleScroll);
    });
  
    onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll);
    });
  </script>

<template>
    <div class="fix fantome" :style="{ top: fantomeTop + 'vh' }">
      <HeaderComponent/>
      <NavbarComponent/>
    </div>
    <CarouselComponent class="reposition" />
    <AppBarComponent />
    <slot name="content"></slot>
    <FooterComponent :data="data" />
</template>
  
  <style lang="scss" scoped>
   @media screen and (min-width: 960px) {
        .fix {
        position: fixed;
        width: 100%;
        z-index: 100;
        }
    
        .reposition {
        position: relative;
        top: 14vh;
        margin-bottom: 14vh;
        }
    
        .fantome {
        transition: top 0.3s ease-in-out;
        }
    }
  </style>
  
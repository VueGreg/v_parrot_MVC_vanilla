<script setup>

    import HeaderComponent from '../components/HeaderComponent.vue';
    import NavbarComponent from '../components/NavbarComponent.vue';
    import CarouselComponent from '../components/CarouselComponent.vue';
    import AppBarComponent from '../components/AppBarComponent.vue'
    import FooterComponent from '../components/FooterComponent.vue';

    import { useStore } from 'vuex';
    import { computed } from 'vue';

    const store = useStore();
    const data = computed(() => store.getters.layoutData);

</script>

<template>

    <HeaderComponent/>
    <NavbarComponent/>
    <CarouselComponent/>
    <AppBarComponent/>
        <slot name="content">

        </slot>
    <FooterComponent :data="data"/>

</template>
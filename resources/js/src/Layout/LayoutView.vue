<script setup>

    import HeaderComponent from '../components/HeaderComponent.vue';
    import NavbarComponent from '../components/NavbarComponent.vue';
    import CarouselComponent from '../components/CarouselComponent.vue';
    import AppBarComponent from '../components/AppBarComponent.vue'
    import FooterComponent from '../components/FooterComponent.vue';

    defineProps({
        data: Object
    })

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
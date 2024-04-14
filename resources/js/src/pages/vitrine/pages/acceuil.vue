<script setup>

    import LastVehiculeComponent from '../../../components/LastVehiculeComponent.vue';
    import ExpertiseComponent from '../../../components/ExpertiseComponent.vue';
    import TemoignageComponent from '../../../components/TemoignageComponent.vue';
    import SocialBarComponent from '../../../components/SocialBarComponent.vue';
    import AvisComponent from '../../../components/AvisComponent.vue';

    defineProps({
        data: Object
    })

</script>

<template>

    <LastVehiculeComponent :data="data.dernier_vehicules"/>
    <ExpertiseComponent/>
    <TemoignageComponent :data="data.temoignages"/>
    <AvisComponent/>
    <SocialBarComponent :data="data.informations"/>

</template>
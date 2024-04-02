<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';
    import LastVehiculeComponent from '../../components/LastVehiculeComponent.vue';
    import ExpertiseComponent from '../../components/ExpertiseComponent.vue';
    import TemoignageComponent from '../../components/TemoignageComponent.vue';
    import SocialBarComponent from '../../components/SocialBarComponent.vue';
    import AvisComponent from '../../components/AvisComponent.vue';

    import { onMounted } from 'vue';
    import { useStore } from 'vuex';

    defineProps({
        data: Object
    })

    const store = useStore();

    onMounted(() => {
        console.log(store.state.layoutData)
    });

</script>

<template>

        <LayoutView>
            <template #content>
                <LastVehiculeComponent/>
                <ExpertiseComponent/>
                <TemoignageComponent :data="data.temoignages"/>
                <AvisComponent/>
                <SocialBarComponent :data="data.informations"/>
            </template>
        </LayoutView>

</template>
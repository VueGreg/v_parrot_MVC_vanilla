<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';
    import { RouterView } from 'vue-router';

    defineProps({
        data: Object
    })

</script>

<template>
    <LayoutView>
        <template #content>
            <RouterView :data="data"/>
        </template>
    </LayoutView>
</template>
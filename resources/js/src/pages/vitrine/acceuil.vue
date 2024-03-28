<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';

    defineProps({
        data: Object
    })

</script>

<template>

        <LayoutView :data="data">
            <template #content>
                <div>
                    <h2>Ceci est la page d'acceuil</h2>
                    <div v-for="image in data.images" :key="image.id">
                        {{ image.nom }}
                    </div>
                </div>
            </template>
        </LayoutView>

</template>
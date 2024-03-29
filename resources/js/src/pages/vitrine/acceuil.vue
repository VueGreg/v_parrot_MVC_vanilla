<script setup>

    import LayoutView from '../../Layout/LayoutView.vue';
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
                <div>
                    <h2>Ceci est la page d'acceuil</h2>
                    <div v-for="image in data.images" :key="image.id">
                        {{ image.nom }}
                    </div>
                </div>
            </template>
        </LayoutView>

</template>
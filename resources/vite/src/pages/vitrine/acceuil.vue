<script setup>

    defineProps({
        data: Object
    })

</script>

<template>
    <div>
        <h2>Ceci est la page d'acceuil</h2>
        <div v-for="image in data.images" :key="image.id">
            {{ image.nom }}
        </div>
    </div>
</template>
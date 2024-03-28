<script setup>

    defineProps({
        data: Object
    })

</script>

<template>
    <div>
        <h2>Ceci est la page d'a propos</h2>
        <div v-for="image in data" :key="image.id">
            <img :src="image.adresse" alt="">
        </div>
    </div>
</template>
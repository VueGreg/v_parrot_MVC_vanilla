<script setup>

    defineProps({
        data: Object
    })

</script>

<template>
    <div>
        <h2>Ceci est la page d'acceuil</h2>
        <p>{{ data }}</p>
    </div>
</template>
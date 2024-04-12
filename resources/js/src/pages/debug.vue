<script setup>

    defineProps({
        data:Object
    })

</script>

<template>
    <h1>page de debug</h1>
    <pre>
        {{ data }}
    </pre>
</template>
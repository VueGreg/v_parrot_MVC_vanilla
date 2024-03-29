<script setup>

    const props = defineProps({
    to: {
            type: String,
            required: true
        },
    params: {
            type: Object,
            default: () => ({})
        }
    });

    const to = () => {
        let href = props.to;
        const params = props.params;

        if (Object.keys(params).length > 0) {
            href += '?' + new URLSearchParams(params).toString();
        }

        return href;
    };

    const send = () => {
        window.location.href = to();
    };

</script>

<template>
    <a :href="to" @click.prevent="send()">
      <slot></slot>
    </a>
  </template>
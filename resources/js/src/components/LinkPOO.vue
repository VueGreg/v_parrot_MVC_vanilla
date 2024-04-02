<script setup>

    const props = defineProps({
    to: {
            type: String,
            required: true
        },
    params: {
            type: Object,
            default: () => ({})
        },
    activeClass: {
            type: String,
        },
    hrefUrl: {
            type: String,
            default: window.location.pathname
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

</script>

<template>
        <a :href="to()" :class="props.to === props.hrefUrl ? props.activeClass : '', $attrs.class">
      <slot></slot>
    </a>
</template>
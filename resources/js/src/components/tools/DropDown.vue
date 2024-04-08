<script setup>

    import { computed, ref, watch } from 'vue';

    const props = defineProps({
        options: {
            type: Array,
            required: false,
            default: null
        },
        default: {
            type: String,
            required: false,
            default: null,
        },
        tabindex: {
            type: Number,
            required: false,
            default: 0
        },
        modelValue: {
          default: null
        },
        watcher: {
          default: false,
          required: true
        }
    });

    const emit = defineEmits(['update:modelValue'])

    const open = ref(false);
    const selected = ref();
    const mappedSelectedOption = computed(() => {
        return (selected.value?.[props.default] || selected.value || 'Selectionnez un/une ' + props.default)
    })

    const toggleOptionSelect = (option) => {
        selected.value = option;
        open.value = false;
        emit('update:modelValue', selected.value?.[props.default]);
    }

    watch(() => props.watcher, () => {
      if (props.watcher == true) {
        selected.value = null
      }
    })

</script>

<template>
    <div class="offcanvas__select" :tabindex="props.tabindex" @blur="open = false">
        <div class="selected" :class="{ open: open }" @click="open = !open">
            {{ mappedSelectedOption }}
        </div>
        <div class="items" :class="{ selectHide: !open }">
            <div class="items__text" v-for="(option, i) of props.options" :key="i" @click="toggleOptionSelect(option)">
                {{ option[props.default] || option }}
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>

  @import '../../../../scss/variable.scss';
  @import '../../../../scss/mixins.scss';

  .offcanvas__select {

      position: relative;
      border: none;
      border-bottom: 1px solid $color-text-dark;
      background-color: white;
      width: 80vw;
      color: $color-text-dark;
      font-size: 1em;
      cursor: pointer;
      padding-bottom: 0.4rem;
  }

  .items {
    position: absolute;
    background-color: white;
    z-index: 1;
    width: 100%;
    border: 0.5px solid gray;
    border-radius: 5px;

    &__text {
      padding: 0.3rem;
    }

    &__text:hover {
      background-color: rgb(200, 202, 200);
      color: rgb(34, 34, 34);
    }
  }

  .selectHide {
    display: none;
  }

  .selected::after {
    content: '<';
    font-size: 1.5rem;
    position: absolute;
    right: 1rem;
    bottom: 0.1rem;
    transform: rotate(-90deg);
    transition: all 0.3s ease-in-out;
  }

  .open.selected::after {
    transform: rotate(90deg);
    right: 0.6rem;
    transition: all 0.3s ease-in-out;
  }
  
</style>
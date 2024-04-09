<script setup>

    import { onMounted, ref } from 'vue';

    const props = defineProps({
        modelValue: {
           type: String,
        },
        for: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        content: {
            type: String,
            required: true
        },
        row: {
            type: Number,
            required: false,
            default: 5
        },
        errors: {
            type: [Array, String],
            required: true,
            default: () => []
        }
        
    });

    defineEmits(['update:modelValue']);

    const areatext = ref(null);

    onMounted(() => {
        if (areatext.value.hasAttribute('autofocus')) {
            areatext.value.focus();
        }
    });

    defineExpose({ focus: () => areatext.value.focus() });

</script>

<template>
    <div class="form__input">
        <textarea class="form__field" 
            ref="areatext" 
            :row="props.row"
            :value="props.modelValue" 
            :type="props.type" 
            :name="props.for" 
            :id="props.for" 
            :placeholder="props.content"
            @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>
        <label class="form__label" :for="props.for">{{ props.content }}</label>
        <span class="form__input-alert" v-if="errors && errors[props.for]">{{ errors[props.for] }}</span>
    </div>
</template>

<style lang="scss" scoped>

    @import '../../../../scss/variable.scss';
    @import '../../../../scss/mixins.scss';


    .form {

        &__input {
            display: flex;
            flex-direction: column;
            color: $orange-formular;
            position: relative;
            padding: 15px 0 0;
            margin-top: 10px;

            &-alert {
                position: relative;
                top: -3em;
                width: 100%;
                text-align: start;
                font-size: 0.6em;
                display: block;
                margin: 0 auto;
                color: red;
                padding-left: 0.2em;
            }
        }
        & p {
            font-size: 1.1em;
            margin-top: 1em;
        }
    }

    .form__label {
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 0.8em;
    color: $orange-formular;
    }

    .form__field {
    font-family: inherit;
    border: 0;
    width: 100%;
    border-bottom: 2px solid $orange-formular;
    outline: 0;
    font-size: 0.8em;
    color: $orange-formular;
    padding: 7px 0;
    background: transparent;
    transition: border-color 0.2s;
    margin: 0.2em auto;
    margin-bottom: 3em;

        &::placeholder {
            color: transparent;
        }

        &:placeholder-shown ~ .form__label {
            font-size: 0.8em;
            cursor: text;
            top: 20px;
        }
    }

    .form__field:focus {
    ~ .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 0.9em;
        color: $primary-color;
        font-weight:700;    
    }
    padding-bottom: 6px;  
    font-weight: 700;
    border-width: 3px;
    border-image: linear-gradient(to right, $orange-formular, $primary-color);
    border-image-slice: 1;
    }

    /* reset input */
    .form__field{
    &:required,&:invalid { box-shadow:none; }
    }

</style>
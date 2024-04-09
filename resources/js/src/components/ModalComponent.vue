<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

</script>

<template>
    <teleport to="body">
        <transition name="modal">
            <div v-show="show" class="show" scroll-region>
                <transition name="modalShow">
                    <div v-show="show" class="back">
                        <div class="back__other" @click="close"/>
                    </div>
                </transition>

                <transition name="other">
                    <div v-show="show" class="window">
                        <slot v-if="show" />
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>

<style lang="scss" scoped>

    .modal-leave-active,
    .modalShow-leave-active
    .other-leave-active {
        transition-duration: 200ms; 
    }

    .modalShow-enter-active {
        transition-duration: 300ms; 
        transition-timing-function: cubic-bezier(0, 0, 0.2, 1); 
    }

    .modalShow-enter-from,
    .modalShow-leave-to {
        opacity: 0;
    }

    .modalShow-enter-to,
    .modalShow-leave-from {
        opacity: 100;
    }

    .other-enter-active {
        transition-duration: 300ms; 
        transition-timing-function: cubic-bezier(0, 0, 0.2, 1); 
    }

    .other-enter-from,
    .other-leave-to {
        --transform-translate-y: 1rem; 
        opacity: 0; 
    }

    .other-enter-to,
    .other-leave-from {
        --transform-translate-y: 0; 
        opacity: 1; 
    }

    .show {
        overflow-y: auto; 
        position: fixed; 
        top: 0;
        right: 0;
        bottom: 0;
        left: 0; 
        z-index: 50; 
        padding-left: 1rem;
        padding-right: 1rem; 
        padding-top: 1.5rem;
        padding-bottom: 1.5rem; 
    }

    .window {
        position: absolute;
        overflow: hidden; 
        margin-bottom: 1.5rem; 
        border-radius: 0.5rem; 
        background-color: #ffffff; 
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms; 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); 
        height: 50vh;
        width: 40vw;
        margin: auto;
        left: calc(60vw/2);
        top: calc(50vh/3);
    }

    .back {
        position: fixed; 
        top: 0;
        right: 0;
        bottom: 0;
        left: 0; 
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms; 

        &__other {
            position: absolute; 
            top: 0;
            right: 0;
            bottom: 0;
            left: 0; 
            background-color: #6B7280; 
            opacity: 0.75; 
        }
    }

    @media (min-width: 640px) {
        .show {
            padding-left: 0;
            padding-right: 0; 
        }

        .other-enter-from,
        .other-leave-to {
            --transform-scale-x: .95;
            --transform-scale-y: .95; 
            --transform-translate-y: 0; 
        }

        .other-enter-to,
        .other-leave-from {
            --transform-scale-x: 1;
            --transform-scale-y: 1;  
        }
    }

</style>
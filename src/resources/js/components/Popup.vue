<template>
    <div
        v-if="isOpen"
        id="overlay"
        class="fixed inset-0 z-50 justify-center overflow-y-scroll bg-black/50 py-10 select-none"
        @mousedown="onOverlayMousedown"
        @mouseup="onOverlayMouseup"
    >
        <div
            id="dialog"
            class="relative mx-auto w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl focus:outline-none"
            role="dialog"
            aria-modal="true"
            :aria-labelledby="title ? 'dialogTitle' : undefined"
        >
            <button
                class="group absolute right-6 flex h-6 w-6 cursor-pointer items-center justify-center"
                @click="isOpen = false"
            >
                <span
                    class="absolute h-0.5 w-full rotate-45 transform rounded-sm bg-gray-600 group-hover:bg-gray-800"
                ></span>
                <span
                    class="absolute h-0.5 w-full -rotate-45 transform rounded-sm bg-gray-600 group-hover:bg-gray-800"
                ></span>
            </button>

            <h2
                v-if="title"
                id="dialogTitle"
                class="mb-4 pr-10 text-xl font-bold"
            >
                {{ title }}
            </h2>

            <div :class="!title ? 'mt-8' : ''">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';

const isOpen = defineModel<boolean>('open', { default: false });
useBodyScrollLock(isOpen);

defineProps({
    title: {
        type: String,
        required: false,
    },
});

let isMouseDownOnOverlay = false;

const onOverlayMousedown = (event: MouseEvent) => {
    const target = event.target as HTMLElement;
    isMouseDownOnOverlay = target.id === 'overlay';
};

const onOverlayMouseup = (event: MouseEvent) => {
    const target = event.target as HTMLElement;

    if (isMouseDownOnOverlay && target.id === 'overlay') {
        isOpen.value = false;
    }

    isMouseDownOnOverlay = false;
};
</script>

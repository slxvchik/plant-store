<template>
    <div v-if="isOpen" id="overlay" class="fixed inset-0 bg-black/50 flex items-center justify-center select-none"
        @click.self="isOpen = false">
        <div id="dialog" class="relative bg-white w-full max-w-xl rounded-lg shadow-xl p-6
              focus:outline-none" role="dialog" aria-modal="true" :aria-labelledby="title ? 'dialogTitle' : undefined">

            <button class="absolute right-6 flex w-6 h-6 items-center justify-center cursor-pointer group"
                @click="isOpen = false">
                <span
                    class="absolute w-full h-0.5 bg-gray-600 rounded-sm transform rotate-45 group-hover:bg-gray-800"></span>
                <span
                    class="absolute w-full h-0.5 bg-gray-600 rounded-sm transform -rotate-45 group-hover:bg-gray-800"></span>
            </button>

            <h2 v-if="title" id="dialogTitle" class="text-xl font-bold mb-4 pr-10">
                {{ title }}
            </h2>

            <slot />

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
        required: false
    }
})
</script>
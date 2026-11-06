<template>
    <button
        type="button"
        class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-white/80 text-text-title transition-all duration-300 hover:scale-110 md:top-3 md:right-3 dark:bg-bg-night/70 dark:text-white"
        :aria-label="
            modelValue ? 'Убрать из избранного' : 'Добавить в избранное'
        "
        :aria-pressed="modelValue"
        @click.prevent="modelValue = !modelValue"
    >
        <span
            class="h-5 w-5"
            :class="modelValue ? 'text-red-400' : 'text-secondary'"
        >
            <AppIcon name="heart" :fill="modelValue" />
        </span>
    </button>
</template>

<script setup lang="ts">
import AppIcon from '@/components/AppIcon.vue';

const modelValue = defineModel<boolean>({});
</script>

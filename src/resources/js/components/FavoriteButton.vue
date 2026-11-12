<template>
    <button
        :aria-label="
            modelValue ? 'Убрать из избранного' : 'Добавить в избранное'
        "
        :aria-pressed="modelValue"
        class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-white/80 text-text-title transition-all duration-300 hover:scale-110 md:top-3 md:right-3 dark:bg-bg-night/70 dark:text-white"
        type="button"
        @click.prevent="modelValue = !modelValue"
    >
        <span
            :class="modelValue ? 'text-red-400' : 'text-secondary'"
            class="h-5 w-5"
        >
            <AppIcon name="heart" />
        </span>
    </button>
</template>

<script lang="ts" setup>
import AppIcon from '@/components/AppIcon.vue';

const modelValue = defineModel<boolean>({});
</script>

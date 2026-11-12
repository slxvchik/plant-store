<template>
    <label class="relative flex-1">
        <span class="sr-only">Поиск по каталогу</span>
        <span
            class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-text-muted dark:text-white/40"
        >
            <AppIcon name="search" />
        </span>
        <input
            :id="id"
            v-model="searchQuery"
            type="search"
            placeholder="Название или сорт растения"
            class="h-12 w-full rounded-2xl border border-text-title/10 bg-bg-elevated pr-4 pl-12 text-sm text-text-title transition-all duration-300 placeholder:text-text-muted/60 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none dark:border-white/10 dark:bg-bg-night-soft dark:text-white dark:placeholder:text-white/30"
        />
        <button
            v-show="searchQuery !== ''"
            type="button"
            @click="searchQuery = ''"
            class="absolute top-1/2 right-2.5 -translate-y-1/2 text-primary transition-colors duration-300 hover:text-text-title"
            aria-label="Очистить поиск"
        >
            <span class="flex h-5 w-5 shrink-0">
                <AppIcon name="cross" />
            </span>
        </button>
    </label>
</template>

<script setup lang="ts">
import AppIcon from '@/components/AppIcon.vue';

const searchQuery = defineModel();
defineProps<{
    id: string;
}>();
</script>

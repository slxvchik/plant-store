<template>
    <button
        @click.prevent
        class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-white/70 text-text-title shadow-sm hover:bg-white"
        aria-label="Добавить в избранное"
    >
        <span class="h-4 w-4">
            <HeartIcon />
        </span>
    </button>
</template>

<script setup lang="ts">
import HeartIcon from '@/components/icons/HeartIcon.vue';
</script>

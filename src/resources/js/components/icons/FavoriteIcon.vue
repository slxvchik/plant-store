<template>
    <button @click.prevent
        class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-white/70 text-main shadow-sm  hover:bg-white"
        aria-label="Добавить в избранное">
        <HeartIcon class="h-4 w-4" />
    </button>
</template>

<script setup lang="ts">
import HeartIcon from '@/components/icons/HeartIcon.vue';
</script>
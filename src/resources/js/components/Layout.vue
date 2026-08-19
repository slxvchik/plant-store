<script setup lang="ts">
import Header from '@/components/Header.vue';
</script>
<template>
    <div class="relative min-h-dvh w-full bg-bg-1">
        <Header />
        <slot />
    </div>
</template>

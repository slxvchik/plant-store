<script setup lang="ts">
import BlogCard from '@/components/BlogCard.vue';
</script>

<template>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6 w-full">
        <BlogCard v-for="n in 3" :key="n" />
    </div>
</template>

<style scoped></style>

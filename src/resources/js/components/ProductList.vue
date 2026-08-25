<template>
    <!-- Product list -->
    <div class="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-5">
        <ProductCard v-for="n in 6" :key="n" />
    </div>
    <!-- !Product list -->
</template>

<script setup lang="ts">
import ProductCard from '@/components/ProductCard.vue';
</script>

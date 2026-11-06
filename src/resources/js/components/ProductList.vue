<template>
    <div class="grid grid-cols-2 gap-3 md:grid-cols-3 md:gap-5 lg:grid-cols-4">
        <ProductCard
            v-for="product in products"
            :key="product.id"
            :product="product"
        />
    </div>
</template>

<script setup lang="ts">
import ProductCard from '@/components/ProductCard.vue';
import { storefrontProducts } from '@/data/products';

withDefaults(defineProps<{ products?: typeof storefrontProducts }>(), {
    products: () => storefrontProducts,
});
</script>

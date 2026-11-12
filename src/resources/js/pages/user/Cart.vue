<template>
    <Container>
        <div class="flex w-full flex-col gap-5 py-5">
            <h1 class="text-4xl text-text-title">Корзина</h1>
            <div
                v-if="!cart || cart.cartLines.length === 0"
                class="text-gray-500"
            >
                Ваша корзина пуста.
            </div>
            <div
                v-else
                class="w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
            ></div>
        </div>
    </Container>
</template>

<script setup lang="ts">
import Container from '@/components/Container.vue';
import Layout from '@/components/layouts/Layout.vue';
import type { Cart } from '@/types/cart';

defineOptions({ layout: Layout });
defineProps<{ cart: Cart | null }>();
</script>

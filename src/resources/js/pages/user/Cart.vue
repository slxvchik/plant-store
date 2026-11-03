<template>
    <div class="mx-auto flex w-full max-w-4xl flex-col gap-5 p-5">
        <h1 class="text-4xl text-text-title">Корзина</h1>
        <div v-if="!cart || cart.cartLines.length === 0" class="text-gray-500">
            Ваша корзина пуста.
        </div>
        <div
            v-else
            class="w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
        >
            <div
                class="grid grid-cols-5 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
            >
                <div class="p-4">Товар</div>
                <div class="p-4">SKU</div>
                <div class="p-4">Цена</div>
                <div class="p-4">Количество</div>
                <div class="p-4">Доступно</div>
            </div>
            <div
                class="divide-y divide-gray-200 bg-white text-sm text-gray-700"
            >
                <div
                    v-for="cartLine in cart.cartLines"
                    :key="`${cartLine.product.productId}:${cartLine.product.offerId}`"
                    class="grid grid-cols-5 transition-colors hover:bg-gray-50"
                >
                    <div class="truncate p-4 font-medium text-gray-900">
                        {{ cartLine.product.name }}
                    </div>
                    <div class="truncate p-4">{{ cartLine.product.sku }}</div>
                    <div class="p-4 whitespace-nowrap">
                        {{ (cartLine.product.price / 100).toFixed(2) }} ₽
                    </div>
                    <div class="p-4">{{ cartLine.quantity }}</div>
                    <div class="p-4">{{ cartLine.availableQuantity }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Layout from '@/components/layouts/Layout.vue';
import type { Cart } from '@/types/cart';

defineOptions({ layout: Layout });
defineProps<{ cart: Cart | null }>();
</script>

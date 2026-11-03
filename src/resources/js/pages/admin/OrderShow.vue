<template>
    <div class="flex flex-col gap-5">
        <div class="w-fit">
            <Link :href="AdminOrders.list.url()" text="Назад" secondary />
        </div>
        <div class="flex flex-row items-center gap-10">
            <h1 class="text-4xl text-text-title">Заказ #{{ order.id }}</h1>
            <OrderStatusButtons :order="order" />
        </div>
        <div class="flex flex-col gap-2 text-sm text-gray-600">
            <span>
                Статус: <b class="text-gray-900">{{ order.status }}</b>
            </span>
            <span>
                Покупатель:
                <b class="text-gray-900">
                    {{ order.user.firstName }} {{ order.user.lastName ?? '' }}
                </b>
            </span>
            <span>
                Email: <b class="text-gray-900">{{ order.user.email }}</b>
            </span>
            <span>
                Телефон: <b class="text-gray-900">{{ order.user.phone }}</b>
            </span>
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-5 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Товар</div>
            <div class="p-4">Количество</div>
            <div class="p-4">Цена</div>
            <div class="p-4">Сумма</div>
            <div class="p-4">Склад</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="orderLine in order.orderLineResponseDto"
                :key="`${orderLine.productId}:${orderLine.offerId}`"
                class="grid grid-cols-5"
            >
                <div class="truncate p-4 font-medium text-gray-900">
                    {{ orderLine.productName ?? 'Товар не найден' }}
                </div>
                <div class="p-4">{{ orderLine.quantity }}</div>
                <div class="p-4 whitespace-nowrap">
                    {{ (orderLine.unitPriceInKopecks / 100).toFixed(2) }} ₽
                </div>
                <div class="p-4 whitespace-nowrap">
                    {{
                        (
                            (orderLine.unitPriceInKopecks *
                                orderLine.quantity) /
                            100
                        ).toFixed(2)
                    }}
                    ₽
                </div>
                <div class="truncate p-4">{{ orderLine.warehouseAddress }}</div>
            </div>
        </div>
    </div>
    <div class="mt-3 text-right text-lg font-semibold text-gray-900">
        Итого: {{ (order.orderSumInKopecks / 100).toFixed(2) }} ₽
    </div>
</template>

<script setup lang="ts">
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import OrderStatusButtons from '@/components/OrderStatusButtons.vue';
import AdminOrders from '@/routes/admin/orders';
import type { Order } from '@/types/order';

defineOptions({ layout: AdminLayout });
defineProps<{ order: Order }>();
</script>

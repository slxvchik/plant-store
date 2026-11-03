<template>
    <div class="flex flex-wrap gap-2">
        <Button
            v-if="order.status === ORDER_STATUS_CREATED"
            text="В обработку"
            class="bg-blue-400 hover:bg-blue-500"
            @click="transition(AdminOrders.take.url(order.id))"
        />
        <Button
            v-if="
                order.status === ORDER_STATUS_CREATED ||
                order.status === ORDER_STATUS_IN_PROGRESS
            "
            text="Отменить"
            class="bg-red-400 hover:bg-red-500"
            @click="transition(AdminOrders.cancel.url(order.id))"
        />
        <Button
            v-if="order.status === ORDER_STATUS_IN_PROGRESS"
            text="Завершить"
            class="bg-green-400 hover:bg-green-500"
            @click="transition(AdminOrders.complete.url(order.id))"
        />
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import Button from '@/components/Button.vue';
import AdminOrders from '@/routes/admin/orders';
import { ORDER_STATUS_CREATED, ORDER_STATUS_IN_PROGRESS } from '@/types/order.ts';

defineProps<{ order: { id: string; status: string } }>();

const transition = (url: string): void => {
    router.put(url, {}, { preserveScroll: true });
};
</script>

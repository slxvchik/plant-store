<template>
    <div class="flex flex-wrap gap-2">
        <Button
            v-if="order.status === ORDER_STATUS_CREATED"
            class="bg-blue-400 hover:bg-blue-500"
            text="В обработку"
            @click="transition(AdminOrders.take.url(order.id))"
        />
        <Button
            v-if="
                order.status === ORDER_STATUS_CREATED ||
                order.status === ORDER_STATUS_IN_PROGRESS
            "
            class="bg-red-400 hover:bg-red-500"
            text="Отменить"
            @click="transition(AdminOrders.cancel.url(order.id))"
        />
        <Button
            v-if="order.status === ORDER_STATUS_IN_PROGRESS"
            class="bg-green-400 hover:bg-green-500"
            text="Завершить"
            @click="transition(AdminOrders.complete.url(order.id))"
        />
    </div>
</template>

<script lang="ts" setup>
import { router } from '@inertiajs/vue3';
import Button from '@/components/Button.vue';
import AdminOrders from '@/routes/admin/orders';
import {
    ORDER_STATUS_CREATED,
    ORDER_STATUS_IN_PROGRESS,
} from '@/types/order.ts';

defineProps<{ order: { id: string; status: string } }>();

const transition = (url: string): void => {
    router.put(url, {}, { preserveScroll: true });
};
</script>

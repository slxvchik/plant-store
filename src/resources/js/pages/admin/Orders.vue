<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Заказы</h1>
        <div class="max-w-80">
            <Button text="Создать" secondary @click="openCreateModal" />
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-5 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Id</div>
            <div class="p-4">Покупатель</div>
            <div class="p-4">Сумма</div>
            <div class="p-4">Статус</div>
            <div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="order in ordersPage.items"
                :key="order.id"
                class="grid grid-cols-5 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">
                    <Link
                        :href="AdminOrders.show.url(order.id)"
                        class="text-secondary hover:text-secondary-hover"
                    >
                        #{{ order.id }}
                    </Link>
                </div>
                <div class="truncate p-4">
                    {{ order.user.firstName }} {{ order.user.lastName ?? '' }}
                </div>
                <div class="p-4 whitespace-nowrap">
                    {{ (order.orderSumInKopecks / 100).toFixed(2) }} ₽
                </div>
                <div class="p-4">{{ order.status }}</div>
                <div class="flex flex-wrap items-center gap-2 p-4">
                    <OrderStatusButtons :order="order" />
                    <Button
                        text="Удалить"
                        class="bg-red-400 hover:bg-red-500"
                        @click="destroy(order.id)"
                    />
                </div>
            </div>
        </div>
    </div>
    <PaginationList v-if="pagination.totalPages > 1" :pagination="pagination" />
    <Popup v-model:open="isFormPopupOpen" title="Создать заказ">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input
                id="userId"
                v-model="form.userId"
                placeholder="Id пользователя"
                label="Id пользователя"
                :error="form.errors.userId"
                @update:modelValue="validateField('userId', form.userId)"
            />
            <p class="text-xs text-gray-500">
                Заказ будет создан из корзины пользователя.
            </p>
            <Button
                type="submit"
                secondary
                :disabled="form.processing"
                text="Создать"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import OrderStatusButtons from '@/components/OrderStatusButtons.vue';
import PaginationList from '@/components/PaginationList.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminOrders from '@/routes/admin/orders';
import type { Order } from '@/types/order';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse';
import { validate } from '@/utils/validator.ts';
import type { PageResponse } from '@/types/pageResponse';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ ordersPage: PageResponse<Order> }>();
const pagination = computed(() =>
    getPaginationFromPageResponse(props.ordersPage),
);

type OrderForm = { userId: string };
const createData = (): OrderForm => ({ userId: '' });
const orderValidator = (field: keyof OrderForm, value: any) => {
    switch (field) {
        case 'userId':
            return validate(value, 'required', 'Id пользователя обязателен');
        default:
            return null;
    }
};
const {
    form,
    validateField,
    isFormPopupOpen,
    openCreateModal,
    submit,
    destroy,
} = useAdminCrudForm<OrderForm, Order>({
    createData,
    editData: () => ({ userId: '' }),
    routes: {
        store: () => AdminOrders.store.url(),
        update: (id) => AdminOrders.take.url(id),
        destroy: (id) => AdminOrders.destroy.url(id),
    },
    validator: orderValidator,
});
</script>

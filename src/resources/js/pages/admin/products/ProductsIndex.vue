<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Товары</h1>
        <div class="w-fit">
            <Link
                :href="AdminProducts.create.url()"
                text="Создать товар"
                styleType="button"
                secondary
            />
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div class="grid w-full grid-cols-4">
            <div class="border-r border-gray-200 p-4">Id</div>
            <div class="border-r border-gray-200 p-4">Название</div>
            <div class="border-r border-gray-200 p-4">Активность</div>
            <div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="product in productsPage.items"
                :key="product.id"
                class="grid grid-cols-4 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">
                    #{{ product.id }}
                </div>
                <div class="p-4 whitespace-nowrap">{{ product.name }}</div>
                <div class="p-4">{{ product.active }}</div>
                <div class="flex gap-2 p-4">
                    <Link
                        text="Смотреть"
                        class="bg-green-400 hover:bg-green-500"
                        :href="AdminRoutes.products.show.url(product.id)"
                    />
                    <Button
                        type="button"
                        text="Удалить"
                        class="w-fit bg-red-400 hover:bg-red-500"
                        styleType="link"
                        @click="deleteProduct(product.id)"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10" v-if="pagination.totalPages > 1">
        <PaginationList :pagination="pagination" />
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import PaginationList from '@/components/PaginationList.vue';
import AdminRoutes from '@/routes/admin';
import AdminProducts from '@/routes/admin/products';
import type { Product } from '@/types';
import type { Page } from '@/types/pagination.ts';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse.ts';

defineOptions({
    layout: AdminLayout,
});

const props = defineProps({
    productsPage: {
        type: Object as () => Page<Product>,
        required: true,
    },
});

const pagination = computed(() => {
    return getPaginationFromPageResponse(props.productsPage);
});

const deleteProduct = (productId: string) => {
    router.delete(AdminProducts.destroy.url(productId), {});
};
</script>

<template>
    <div class="space-y-6">
        <AdminPageHeader
            title="Товары"
            eyebrow="Каталог"
            description="Управляйте карточками товаров, предложениями и видимостью в каталоге."
        >
            <template #actions>
                <Link
                    :href="AdminProducts.create.url()"
                    class="inline-flex rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                    text="Создать товар"
                />
            </template>
        </AdminPageHeader>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase">
                        <tr><th class="px-5 py-4">ID</th><th class="px-5 py-4">Название</th><th class="px-5 py-4">Активность</th><th class="px-5 py-4 text-right">Действия</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="product in productsPage.items" :key="product.id" class="transition hover:bg-slate-50">
                            <td class="px-5 py-4 font-mono text-xs text-slate-400">#{{ product.id.slice(0, 8) }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ product.name }}</td>
                            <td class="px-5 py-4"><Badge :label="product.active ? 'Активен' : 'Скрыт'" :tone="product.active ? 'success' : 'neutral'" /></td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <Link :href="AdminRoutes.products.show.url(product.id)" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-emerald-200 hover:text-emerald-700" text="Открыть" />
                                    <Button class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-rose-600 hover:!bg-rose-50" text="Удалить" type="button" @click="deleteProduct(product.id)" />
                                </div>
                            </td>
                        </tr>
                        <tr v-if="productsPage.items.length === 0"><td colspan="4" class="px-5 py-16 text-center text-slate-500">Товары ещё не созданы.</td></tr>
                    </tbody>
                </table>
            </div>
            <PaginationList :pagination="pagination" />
        </section>
    </div>
</template>

<script lang="ts" setup>
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
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

<template>
    <div class="space-y-6">
        <AdminPageHeader
            description="Регистрируйте поступления и автоматически формируйте складские единицы."
            eyebrow="Закупки"
            title="Поставки"
        >
            <template #actions>
                <Link
                    class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700"
                    href="/admin/product-supplies/create"
                >
                    Новая поставка
                </Link>
            </template>
        </AdminPageHeader>
        <div class="grid gap-4 sm:grid-cols-3">
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >
                <p class="text-sm text-slate-500">Поставок на странице</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950">
                    {{ productSuppliesPage.items.length }}
                </p>
            </div>
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >
                <p class="text-sm text-slate-500">Заявлено единиц</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950">
                    {{ declaredTotal }}
                </p>
            </div>
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm"
            >
                <p class="text-sm text-emerald-700">Сгенерировано единиц</p>
                <p class="mt-2 text-2xl font-semibold text-emerald-950">
                    {{ actualTotal }}
                </p>
            </div>
        </div>
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] text-left text-sm">
                    <thead
                        class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-4">Поставка</th>
                            <th class="px-5 py-4">Поставщик</th>
                            <th class="px-5 py-4">Товар</th>
                            <th class="px-5 py-4">Количество</th>
                            <th class="px-5 py-4">Стоимость</th>
                            <th class="px-5 py-4">Отметка</th>
                            <th class="px-5 py-4 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="supply in productSuppliesPage.items"
                            :key="supply.id"
                            class="hover:bg-slate-50/80"
                        >
                            <td class="px-5 py-4">
                                <Link
                                    :href="`/admin/product-supplies/${supply.id}`"
                                    class="font-mono text-xs font-semibold text-slate-800 hover:text-emerald-700"
                                >
                                    #{{ supply.id.slice(0, 8) }}
                                </Link>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ formatDate(supply.createdAt) }}
                                </p>
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-700">
                                {{ supplierName(supply.supplierId) }}
                            </td>
                            <td class="max-w-64 px-5 py-4 text-slate-600">
                                {{ offerName(supply.offerId) }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-semibold text-slate-900">
                                    {{ supply.actualQuantity }}
                                </span>
                                <span class="text-slate-400">
                                    / {{ supply.declaredQuantity }} шт.
                                </span>
                                <p class="mt-1 text-xs text-slate-400">
                                    факт / план
                                </p>
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                {{
                                    formatMoney(
                                        supply.totalPurchasePriceInKopecks,
                                    )
                                }}
                            </td>
                            <td class="px-5 py-4">
                                <span
                                    v-if="supply.misGraded"
                                    class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-200 ring-inset"
                                >
                                    Пересорт
                                </span>
                                <span v-else class="text-slate-400">—</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <Link
                                    :href="`/admin/product-supplies/${supply.id}`"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700"
                                >
                                    Открыть
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="productSuppliesPage.items.length === 0">
                            <td
                                class="px-5 py-16 text-center text-slate-500"
                                colspan="7"
                            >
                                Поставки ещё не зарегистрированы.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <PaginationList :pagination="productSuppliesPage" />
        </section>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import PaginationList from '@/components/PaginationList.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import type { ProductOption, ProductSupply, Supplier } from '@/types/inventory.ts';
import type { Page } from '@/types/pagination.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    productSuppliesPage: Page<ProductSupply>;
    products: ProductOption[];
    suppliers: Supplier[];
}>();
const declaredTotal = computed(() =>
    props.productSuppliesPage.items.reduce(
        (sum, supply) => sum + supply.declaredQuantity,
        0,
    ),
);
const actualTotal = computed(() =>
    props.productSuppliesPage.items.reduce(
        (sum, supply) => sum + supply.actualQuantity,
        0,
    ),
);
const supplierName = (id: string | null) =>
    props.suppliers.find((supplier) => supplier.id === id)?.name ?? 'Не указан';
const offerName = (id: string | null) => {
    for (const product of props.products) {
        const offer = product.offers.find((item) => item.id === id);
        if (offer)
            return `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`;
    }
    return 'Не указан';
};
const formatDate = (date: string) =>
    new Intl.DateTimeFormat('ru-RU', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(date));
const formatMoney = (value: number | null) =>
    value === null
        ? '—'
        : `${new Intl.NumberFormat('ru-RU').format(value / 100)} ₽`;
</script>

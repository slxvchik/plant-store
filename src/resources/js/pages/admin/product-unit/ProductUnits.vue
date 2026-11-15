<template>
    <div class="space-y-6">
        <AdminPageHeader
            description="Отслеживайте каждое растение, его расположение, статус и связь с поставкой."
            eyebrow="Складской учёт"
            title="Единицы товара"
        >
            <template #actions>
                <Link
                    class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700"
                    href="/admin/product-units/create"
                >
                    Создать / сгенерировать
                </Link>
            </template>
        </AdminPageHeader>
        <form
            class="grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-2 xl:grid-cols-5"
            @submit.prevent="applyFilters"
        >
            <select v-model="filterState.offerId" :class="selectClass">
                <option :value="null">Все товары</option>
                <option
                    v-for="option in offerOptions"
                    :key="option.value"
                    :value="option.value"
                >
                    {{ option.label }}
                </option>
            </select>
            <select v-model="filterState.warehouseId" :class="selectClass">
                <option :value="null">Все склады</option>
                <option
                    v-for="warehouse in warehouses"
                    :key="warehouse.id"
                    :value="warehouse.id"
                >
                    {{ warehouse.address }}
                </option>
            </select>
            <select
                v-model="filterState.productUnitStatusId"
                :class="selectClass"
            >
                <option :value="null">Все статусы</option>
                <option
                    v-for="status in statuses"
                    :key="status.id"
                    :value="status.id"
                >
                    {{ status.name }}
                </option>
            </select>
            <select v-model="filterState.productSupplyId" :class="selectClass">
                <option :value="null">Все поставки</option>
                <option
                    v-for="supply in supplies"
                    :key="supply.id"
                    :value="supply.id"
                >
                    {{ supply.id.slice(0, 8) }}
                </option>
            </select>
            <div class="flex gap-2">
                <button
                    class="flex-1 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-700"
                    type="submit"
                >
                    Применить
                </button>
                <button
                    class="rounded-xl px-3 text-sm text-slate-500 hover:bg-slate-100"
                    type="button"
                    @click="resetFilters"
                >
                    Сбросить
                </button>
            </div>
        </form>
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left text-sm">
                    <thead
                        class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-4">Единица</th>
                            <th class="px-5 py-4">Товар</th>
                            <th class="px-5 py-4">Склад</th>
                            <th class="px-5 py-4">Статус</th>
                            <th class="px-5 py-4">Поставка</th>
                            <th class="px-5 py-4">Резерв</th>
                            <th class="px-5 py-4 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="unit in productUnitsPage.items"
                            :key="unit.id"
                            class="hover:bg-slate-50/80"
                        >
                            <td class="px-5 py-4">
                                <Link
                                    :href="`/admin/product-units/${unit.id}`"
                                    class="font-mono text-xs font-semibold text-slate-700 hover:text-emerald-700"
                                >
                                    #{{ unit.id.slice(0, 8) }}
                                </Link>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ unit.qrCode || 'QR не задан' }}
                                </p>
                            </td>
                            <td
                                class="max-w-64 px-5 py-4 font-medium text-slate-700"
                            >
                                {{ offerLabel(unit.offerId) }}
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ warehouseLabel(unit.warehouseId) }}
                            </td>
                            <td class="px-5 py-4">
                                <Badge
                                    :label="
                                        statusLabel(unit.productUnitStatusId)
                                    "
                                />
                            </td>
                            <td
                                class="px-5 py-4 font-mono text-xs text-slate-500"
                            >
                                {{ unit.productSupplyId?.slice(0, 8) || '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <span
                                    :class="
                                        unit.reserved
                                            ? 'bg-amber-50 text-amber-700 ring-amber-200'
                                            : 'bg-slate-50 text-slate-500 ring-slate-200'
                                    "
                                    class="rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset"
                                >
                                    {{
                                        unit.reserved
                                            ? 'Зарезервировано'
                                            : 'Свободно'
                                    }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="`/admin/product-units/${unit.id}`"
                                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700"
                                    >
                                        Изменить
                                    </Link>
                                    <button
                                        class="rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50"
                                        type="button"
                                        @click="destroy(unit.id)"
                                    >
                                        Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="productUnitsPage.items.length === 0">
                            <td
                                class="px-5 py-16 text-center text-slate-500"
                                colspan="7"
                            >
                                По выбранным фильтрам единицы не найдены.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <PaginationList :pagination="productUnitsPage" />
        </section>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import PaginationList from '@/components/PaginationList.vue';
import Badge from '@/components/Badge.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductSupply,
    ProductUnit,
    ProductUnitFilters,
    ProductUnitStatus
} from '@/types/inventory.ts';
import type { Page } from '@/types/pagination.ts';
import type { Warehouse } from '@/types/warehouse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    productUnitsPage: Page<ProductUnit>;
    filters: ProductUnitFilters;
    products: ProductOption[];
    warehouses: Warehouse[];
    statuses: ProductUnitStatus[];
    supplies: ProductSupply[];
}>();
const selectClass =
    'h-11 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-600 outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100';
const filterState = reactive<ProductUnitFilters>({ ...props.filters });
const offerOptions = computed(() =>
    props.products.flatMap((product) =>
        product.offers.map((offer) => ({
            value: offer.id,
            label: `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`,
        })),
    ),
);
const offerLabel = (id: string | null) =>
    offerOptions.value.find((offer) => offer.value === id)?.label ??
    'Не указан';
const warehouseLabel = (id: string) =>
    props.warehouses.find((warehouse) => warehouse.id === id)?.address ??
    'Не указан';
const statusLabel = (id: string) =>
    props.statuses.find((status) => status.id === id)?.name ?? 'Без статуса';
const applyFilters = () =>
    router.get(
        '/admin/product-units',
        Object.fromEntries(
            Object.entries(filterState).filter(([, value]) => value !== null),
        ),
        { preserveState: true, preserveScroll: true },
    );
const resetFilters = () => {
    Object.assign(filterState, {
        offerId: null,
        warehouseId: null,
        productUnitStatusId: null,
        productSupplyId: null,
    });
    applyFilters();
};
const destroy = (id: string) => {
    if (window.confirm('Удалить единицу товара?')) {
        router.delete(`/admin/product-units/${id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <div class="space-y-6">
        <AdminPageHeader
            :description="`Создана ${formatDate(productSupply.createdAt)}`"
            :title="`Поставка #${productSupply.id.slice(0, 8)}`"
            back-url="/admin/product-supplies"
            eyebrow="Детали поступления"
        >
            <template #actions>
                <button
                    class="rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50"
                    type="button"
                    @click="destroy"
                >
                    Удалить поставку
                </button>
            </template>
        </AdminPageHeader>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div
                v-for="card in summaryCards"
                :key="card.label"
                class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
            >
                <p
                    class="text-xs font-semibold tracking-wider text-slate-400 uppercase"
                >
                    {{ card.label }}
                </p>
                <p class="mt-2 font-semibold text-slate-900">
                    {{ card.value }}
                </p>
            </div>
        </div>
        <section
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
        >
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">
                        Информация о закупке
                    </h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Поставщик</dt>
                            <dd class="text-right font-medium text-slate-800">
                                {{ supplierName }}
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Товар</dt>
                            <dd class="text-right font-medium text-slate-800">
                                {{ offerName }}
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Склад</dt>
                            <dd class="text-right font-medium text-slate-800">
                                {{ warehouseName }}
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-500">Пересорт</dt>
                            <dd
                                :class="
                                    productSupply.misGraded
                                        ? 'text-amber-700'
                                        : 'text-slate-800'
                                "
                                class="font-medium"
                            >
                                {{ productSupply.misGraded ? 'Да' : 'Нет' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">
                        Комментарий
                    </h2>
                    <p
                        class="mt-4 rounded-xl bg-slate-50 p-4 text-sm leading-6 whitespace-pre-wrap text-slate-600"
                    >
                        {{
                            productSupply.comment || 'Комментарий не добавлен.'
                        }}
                    </p>
                </div>
            </div>
        </section>
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <div
                class="flex items-center justify-between border-b border-slate-100 px-6 py-5"
            >
                <div>
                    <h2 class="font-semibold text-slate-900">Единицы товара</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ productUnits.length }} записей связано с этой
                        поставкой
                    </p>
                </div>
                <Link
                    class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700"
                    href="/admin/product-units/create"
                >
                    Добавить единицы
                </Link>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead
                        class="bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"
                    >
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Статус</th>
                            <th class="px-6 py-3">Резерв</th>
                            <th class="px-6 py-3">QR</th>
                            <th class="px-6 py-3">Комментарий</th>
                            <th class="px-6 py-3 text-right">Действие</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="unit in productUnits" :key="unit.id">
                            <td
                                class="px-6 py-4 font-mono text-xs text-slate-600"
                            >
                                {{ unit.id.slice(0, 8) }}
                            </td>
                            <td class="px-6 py-4">
                                <Badge
                                    :label="
                                        statusName(unit.productUnitStatusId)
                                    "
                                />
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ unit.reserved ? 'Да' : 'Нет' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ unit.qrCode || 'Не задан' }}
                            </td>
                            <td
                                class="max-w-56 truncate px-6 py-4 text-slate-500"
                            >
                                {{ unit.comments || '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <Link
                                    :href="`/admin/product-units/${unit.id}`"
                                    class="text-xs font-semibold text-emerald-700 hover:underline"
                                >
                                    Открыть
                                </Link>
                            </td>
                        </tr>
                        <tr v-if="productUnits.length === 0">
                            <td
                                class="px-6 py-12 text-center text-slate-500"
                                colspan="6"
                            >
                                С поставкой пока не связано ни одной единицы.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import type { ProductOption, ProductSupply, ProductUnit, ProductUnitStatus, Supplier } from '@/types/inventory.ts';
import type { Warehouse } from '@/types/warehouse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    productSupply: ProductSupply;
    productUnits: ProductUnit[];
    products: ProductOption[];
    suppliers: Supplier[];
    warehouses: Warehouse[];
    statuses: ProductUnitStatus[];
}>();
const supplierName = computed(
    () =>
        props.suppliers.find(
            (supplier) => supplier.id === props.productSupply.supplierId,
        )?.name ?? 'Не указан',
).value;
const offerName = computed(() => {
    for (const product of props.products) {
        const offer = product.offers.find(
            (item) => item.id === props.productSupply.offerId,
        );
        if (offer)
            return `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`;
    }
    return 'Не указан';
}).value;
const warehouseName = computed(
    () =>
        props.warehouses.find(
            (warehouse) => warehouse.id === props.productUnits[0]?.warehouseId,
        )?.address ?? 'Не указан',
).value;
const summaryCards = [
    { label: 'Заявлено', value: `${props.productSupply.declaredQuantity} шт.` },
    { label: 'Фактически', value: `${props.productSupply.actualQuantity} шт.` },
    {
        label: 'Цена за единицу',
        value: formatMoney(props.productSupply.unitPurchasePriceInKopecks),
    },
    {
        label: 'Общая стоимость',
        value: formatMoney(props.productSupply.totalPurchasePriceInKopecks),
    },
];
const statusName = (id: string) =>
    props.statuses.find((status) => status.id === id)?.name ?? 'Без статуса';
const formatDate = (date: string) =>
    new Intl.DateTimeFormat('ru-RU', {
        dateStyle: 'long',
        timeStyle: 'short',
    }).format(new Date(date));
function formatMoney(value: number | null) {
    return value === null
        ? '—'
        : `${new Intl.NumberFormat('ru-RU').format(value / 100)} ₽`;
}
const destroy = () => {
    if (
        window.confirm('Удалить поставку? Связанные единицы останутся в учёте.')
    )
        router.delete(`/admin/product-supplies/${props.productSupply.id}`);
};
</script>

<template>
    <div class="product-units">
        <AdminPageHeader
            description="Отслеживайте каждое растение, его расположение, статус и связь с поставкой."
            eyebrow="Складской учёт"
            title="Единицы товара"
        >
            <template #actions>
                <Link
                    class="product-units__create"
                    href="/admin/product-units/create"
                >
                    Создать / сгенерировать
                </Link>
            </template>
        </AdminPageHeader>
        <AdminFilterBar @submit="applyFilters">
            <Select
                v-model="filterState.offerId"
                :items="offerOptions"
                label="Товар"
                placeholder="Все товары"
            />
            <Select
                v-model="filterState.warehouseId"
                :items="warehouseOptions"
                label="Склад"
                placeholder="Все склады"
            />
            <Select
                v-model="filterState.productUnitStatusId"
                :items="statusOptions"
                label="Статус"
                placeholder="Все статусы"
            />
            <Select
                v-model="filterState.productSupplyId"
                :items="supplyOptions"
                label="Поставка"
                placeholder="Все поставки"
            />
            <template #actions>
                <Button auto-width text="Применить" type="submit" />
                <Button
                    auto-width
                    ghost
                    text="Сбросить"
                    type="button"
                    @click="resetFilters"
                />
            </template>
        </AdminFilterBar>
        <Table>
            <thead>
                <tr>
                    <th>Единица</th>
                    <th>Товар</th>
                    <th>Склад</th>
                    <th>Статус</th>
                    <th>Поставка</th>
                    <th>Резерв</th>
                    <th class="product-units__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="unit in productUnitsPage.items" :key="unit.id">
                    <td>
                        <Link
                            :href="`/admin/product-units/${unit.id}`"
                            class="product-units__unit"
                        >
                            #{{ unit.id.slice(0, 8) }}
                        </Link>
                        <p class="product-units__qr">
                            {{ unit.qrCode || 'QR не задан' }}
                        </p>
                    </td>
                    <td class="product-units__offer">
                        {{ offerLabel(unit.offerId) }}
                    </td>
                    <td class="product-units__muted">
                        {{ warehouseLabel(unit.warehouseId) }}
                    </td>
                    <td>
                        <Badge :label="statusLabel(unit.productUnitStatusId)" />
                    </td>
                    <td class="product-units__supply">
                        {{ unit.productSupplyId?.slice(0, 8) || '—' }}
                    </td>
                    <td>
                        <Badge
                            :label="
                                unit.reserved ? 'Зарезервировано' : 'Свободно'
                            "
                            :tone="unit.reserved ? 'warning' : 'neutral'"
                        />
                    </td>
                    <td>
                        <div class="product-units__actions">
                            <Link
                                :href="`/admin/product-units/${unit.id}`"
                                class="product-units__edit"
                            >
                                Изменить
                            </Link>
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                @click="destroy(unit.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="productUnitsPage.items.length === 0">
                    <td class="product-units__empty" colspan="7">
                        По выбранным фильтрам единицы не найдены.
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="productUnitsPage" />
            </template>
        </Table>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import AdminFilterBar from '@/components/admin/AdminFilterBar.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Pagination from '@/components/Pagination.vue';
import Select from '@/components/Select.vue';
import Table from '@/components/Table.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductSupply,
    ProductUnit,
    ProductUnitFilters,
    ProductUnitStatus,
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
const filterState = reactive<ProductUnitFilters>({ ...props.filters });
const offerOptions = computed(() =>
    props.products.flatMap((product) =>
        product.offers.map((offer) => ({
            value: offer.id,
            label: `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`,
        })),
    ),
);
const warehouseOptions = computed(() =>
    props.warehouses.map((warehouse) => ({
        value: warehouse.id,
        label: warehouse.address,
    })),
);
const statusOptions = computed(() =>
    props.statuses.map((status) => ({ value: status.id, label: status.name })),
);
const supplyOptions = computed(() =>
    props.supplies.map((supply) => ({
        value: supply.id,
        label: supply.id.slice(0, 8),
    })),
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

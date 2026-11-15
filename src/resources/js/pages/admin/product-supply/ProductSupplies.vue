<template>
    <div class="product-supplies">
        <AdminPageHeader
            description="Регистрируйте поступления и автоматически формируйте складские единицы."
            eyebrow="Закупки"
            title="Поставки"
        >
            <template #actions>
                <Link
                    class="product-supplies__create"
                    href="/admin/product-supplies/create"
                >
                    Новая поставка
                </Link>
            </template>
        </AdminPageHeader>
        <div class="product-supplies__stats">
            <div class="product-supplies__stat">
                <p class="product-supplies__stat-label">Поставок на странице</p>
                <p class="product-supplies__stat-value">
                    {{ productSuppliesPage.items.length }}
                </p>
            </div>
            <div class="product-supplies__stat">
                <p class="product-supplies__stat-label">Заявлено единиц</p>
                <p class="product-supplies__stat-value">{{ declaredTotal }}</p>
            </div>
            <div class="product-supplies__stat product-supplies__stat--accent">
                <p class="product-supplies__stat-label">Сгенерировано единиц</p>
                <p class="product-supplies__stat-value">{{ actualTotal }}</p>
            </div>
        </div>
        <Table>
            <thead>
                <tr>
                    <th>Поставка</th>
                    <th>Поставщик</th>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Отметка</th>
                    <th class="product-supplies__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="supply in productSuppliesPage.items"
                    :key="supply.id"
                >
                    <td>
                        <Link
                            :href="`/admin/product-supplies/${supply.id}`"
                            class="product-supplies__id"
                        >
                            #{{ supply.id.slice(0, 8) }}
                        </Link>
                        <p class="product-supplies__date">
                            {{ formatDate(supply.createdAt) }}
                        </p>
                    </td>
                    <td class="product-supplies__supplier">
                        {{ supplierName(supply.supplierId) }}
                    </td>
                    <td class="product-supplies__offer">
                        {{ offerName(supply.offerId) }}
                    </td>
                    <td>
                        <span class="product-supplies__actual">
                            {{ supply.actualQuantity }}
                        </span>
                        <span class="product-supplies__declared">
                            / {{ supply.declaredQuantity }} шт.
                        </span>
                        <p class="product-supplies__quantity-hint">
                            факт / план
                        </p>
                    </td>
                    <td class="product-supplies__price">
                        {{ formatMoney(supply.totalPurchasePriceInKopecks) }}
                    </td>
                    <td>
                        <Badge
                            v-if="supply.misGraded"
                            label="Пересорт"
                            tone="warning"
                        />
                        <span v-else class="product-supplies__dash">—</span>
                    </td>
                    <td class="product-supplies__cell--actions">
                        <Link
                            :href="`/admin/product-supplies/${supply.id}`"
                            class="product-supplies__open"
                        >
                            Открыть
                        </Link>
                    </td>
                </tr>
                <tr v-if="productSuppliesPage.items.length === 0">
                    <td class="product-supplies__empty" colspan="7">
                        Поставки ещё не зарегистрированы.
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="productSuppliesPage" />
            </template>
        </Table>
    </div>
</template>
<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Pagination from '@/components/Pagination.vue';
import Table from '@/components/Table.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductSupply,
    Supplier,
} from '@/types/inventory.ts';
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

        if (offer) {
            return `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`;
        }
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

<template>
    <div class="product-supply-show">
        <AdminPageHeader
            :description="`Создана ${formatDate(productSupply.createdAt)}`"
            :title="`Поставка #${productSupply.id.slice(0, 8)}`"
            back-url="/admin/product-supplies"
            eyebrow="Детали поступления"
        >
            <template #actions>
                <Button
                    auto-width
                    danger
                    ghost
                    text="Удалить поставку"
                    @click="destroy"
                />
            </template>
        </AdminPageHeader>
        <div class="product-supply-show__stats">
            <Card
                v-for="card in summaryCards"
                :key="card.label"
                class="product-supply-show__stat"
            >
                <p class="product-supply-show__stat-label">{{ card.label }}</p>
                <p class="product-supply-show__stat-value">{{ card.value }}</p>
            </Card>
        </div>
        <Card class="product-supply-show__information">
            <div class="product-supply-show__columns">
                <div>
                    <h2 class="product-supply-show__heading">
                        Информация о закупке
                    </h2>
                    <dl class="product-supply-show__list">
                        <div class="product-supply-show__row">
                            <dt>Поставщик</dt>
                            <dd>{{ supplierName }}</dd>
                        </div>
                        <div class="product-supply-show__row">
                            <dt>Товар</dt>
                            <dd>{{ offerName }}</dd>
                        </div>
                        <div class="product-supply-show__row">
                            <dt>Склад</dt>
                            <dd>{{ warehouseName }}</dd>
                        </div>
                        <div class="product-supply-show__row">
                            <dt>Пересорт</dt>
                            <dd
                                :class="{
                                    'product-supply-show__warning':
                                        productSupply.misGraded,
                                }"
                            >
                                {{ productSupply.misGraded ? 'Да' : 'Нет' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h2 class="product-supply-show__heading">Комментарий</h2>
                    <p class="product-supply-show__comment">
                        {{
                            productSupply.comment || 'Комментарий не добавлен.'
                        }}
                    </p>
                </div>
            </div>
        </Card>
        <section class="product-supply-show__units">
            <div class="product-supply-show__units-header">
                <div>
                    <h2 class="product-supply-show__units-title">
                        Единицы товара
                    </h2>
                    <p class="product-supply-show__units-count">
                        {{ productUnits.length }} записей связано с этой
                        поставкой
                    </p>
                </div>
                <Link
                    class="product-supply-show__add"
                    href="/admin/product-units/create"
                >
                    Добавить единицы
                </Link>
            </div>
            <Table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Статус</th>
                        <th>Резерв</th>
                        <th>Комментарий</th>
                        <th class="product-supply-show__cell--actions">
                            Действие
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="unit in productUnits" :key="unit.id">
                        <td class="product-supply-show__unit-id">
                            {{ unit.id.slice(0, 8) }}
                        </td>
                        <td>
                            <Badge
                                :label="statusName(unit.productUnitStatusId)"
                            />
                        </td>
                        <td class="product-supply-show__muted">
                            {{ unit.reserved ? 'Да' : 'Нет' }}
                        </td>
                        <td class="product-supply-show__unit-comment">
                            {{ unit.comments || '—' }}
                        </td>
                        <td class="product-supply-show__cell--actions">
                            <Link
                                :href="`/admin/product-units/${unit.id}`"
                                class="product-supply-show__open"
                            >
                                Открыть
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="productUnits.length === 0">
                        <td class="product-supply-show__empty" colspan="6">
                            С поставкой пока не связано ни одной единицы.
                        </td>
                    </tr>
                </tbody>
            </Table>
        </section>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Table from '@/components/Table.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductSupply,
    ProductUnit,
    ProductUnitStatus,
    Supplier,
} from '@/types/inventory.ts';
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

        if (offer) {
            return `${product.name} — ${offer.sku || offer.id.slice(0, 8)}`;
        }
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
    ) {
        router.delete(`/admin/product-supplies/${props.productSupply.id}`);
    }
};
</script>

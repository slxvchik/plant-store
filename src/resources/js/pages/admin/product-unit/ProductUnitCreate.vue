<template>
    <div class="product-unit-create">
        <AdminPageHeader
            back-url="/admin/product-units"
            description="Создайте одну единицу вручную или сформируйте партию."
            eyebrow="Складской учёт"
            title="Создание единиц товара"
        />
        <div class="product-unit-create__tabs">
            <Button
                :class="tabClasses('batch')"
                style-type="link"
                type="button"
                @click="mode = 'batch'"
            >
                Партия
            </Button>
            <Button
                :class="tabClasses('single')"
                style-type="link"
                type="button"
                @click="mode = 'single'"
            >
                Одна единица
            </Button>
        </div>
        <form class="product-unit-create__form" @submit.prevent="submit">
            <div class="product-unit-create__grid">
                <div class="product-unit-create__wide">
                    <Select
                        v-model="form.offerId"
                        :error="form.errors.offerId"
                        :items="offerOptions"
                        label="Товар / торговое предложение"
                        placeholder="Выберите предложение"
                        searchable
                        required
                    />
                </div>
                <Select
                    v-model="form.warehouseId"
                    :error="form.errors.warehouseId"
                    :items="warehouseOptions"
                    label="Склад"
                    required
                />
                <Select
                    v-model="form.productUnitStatusId"
                    :error="form.errors.productUnitStatusId"
                    :items="statusOptions"
                    label="Начальный статус"
                    required
                />
                <Select
                    v-model="form.productSupplyId"
                    :error="form.errors.productSupplyId"
                    :items="supplyOptions"
                    label="Поставка"
                    placeholder="Без поставки"
                />
                <Input
                    v-model="form.sowingDate"
                    :error="form.errors.sowingDate"
                    label="Дата посева"
                    type="date"
                />
                <Input
                    v-if="mode === 'batch'"
                    v-model="form.quantity"
                    :error="form.errors.quantity"
                    :max="1000"
                    :min="1"
                    hint="От 1 до 1000 записей за одну операцию."
                    label="Количество"
                    required
                    type="number"
                />
                <Checkbox
                    v-if="mode === 'single'"
                    v-model="form.reserved"
                    description="Единица будет недоступна для других заказов"
                    text="Зарезервировано"
                />
                <div v-else class="product-unit-create__preview">
                    <span class="product-unit-create__preview-title">
                        Будет создано: {{ form.quantity || 0 }} шт.
                    </span>
                </div>
                <div class="product-unit-create__wide">
                    <Textarea
                        v-model="form.comments"
                        :error="form.errors.comments"
                        label="Комментарии"
                        placeholder="Общий комментарий для создаваемых записей"
                    />
                </div>
            </div>
            <div class="product-unit-create__footer">
                <p>Все записи создаются в одной транзакции.</p>
                <Button
                    :disabled="form.processing"
                    :text="
                        form.processing
                            ? 'Создание…'
                            : mode === 'batch'
                              ? `Сгенерировать ${form.quantity || 0} шт.`
                              : 'Создать единицу'
                    "
                    auto-width
                    secondary
                    type="submit"
                />
            </div>
        </form>
    </div>
</template>
<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import Textarea from '@/components/Textarea.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductSupply,
    ProductUnitStatus,
} from '@/types/inventory.ts';
import type { Warehouse } from '@/types/warehouse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    products: ProductOption[];
    warehouses: Warehouse[];
    statuses: ProductUnitStatus[];
    supplies: ProductSupply[];
}>();
type UnitCreateForm = {
    quantity: number;
    productSupplyId: string | null;
    offerId: string | null;
    warehouseId: string;
    reserved: boolean;
    sowingDate: string | null;
    productUnitStatusId: string;
    comments: string;
};
const mode = ref<'batch' | 'single'>('batch');
const tabClasses = (tabMode: 'batch' | 'single') => [
    'product-unit-create__tab',
    { 'product-unit-create__tab--active': mode.value === tabMode },
];
const form = useForm<UnitCreateForm>({
    quantity: 10,
    productSupplyId: null,
    offerId: null,
    warehouseId: '',
    reserved: false,
    sowingDate: null,
    productUnitStatusId: '',
    comments: '',
});
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
        label: `${supply.id.slice(0, 8)} · ${supply.actualQuantity} шт.`,
    })),
);
const submit = () => {
    if (mode.value === 'batch') {
        form.transform((data) => ({
            quantity: data.quantity,
            offerId: data.offerId,
            warehouseId: data.warehouseId,
            productUnitStatusId: data.productUnitStatusId,
            productSupplyId: data.productSupplyId,
            sowingDate: data.sowingDate,
            comments: data.comments,
        })).post('/admin/product-units/batch');
    } else {
        form.transform((data) => ({
            productSupplyId: data.productSupplyId,
            offerId: data.offerId,
            warehouseId: data.warehouseId,
            reserved: data.reserved,
            sowingDate: data.sowingDate,
            productUnitStatusId: data.productUnitStatusId,
            comments: data.comments,
        })).post('/admin/product-units');
    }
};
</script>

<template>
    <form
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        @submit.prevent="submit"
    >
        <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
            <div class="sm:col-span-2">
                <Select
                    id="product-unit-offer"
                    v-model="form.offerId"
                    :error="form.errors.offerId"
                    :items="offerOptions"
                    label="Товар / торговое предложение"
                    placeholder="Выберите предложение"
                    required
                    variant="standard"
                />
            </div>
            <Select
                id="product-unit-warehouse"
                v-model="form.warehouseId"
                :error="form.errors.warehouseId"
                :items="warehouseOptions"
                label="Склад"
                placeholder="Выберите склад"
                required
                variant="standard"
            />
            <Select
                id="product-unit-status"
                v-model="form.productUnitStatusId"
                :error="form.errors.productUnitStatusId"
                :items="statusOptions"
                label="Статус"
                placeholder="Выберите статус"
                required
                variant="standard"
            />
            <Select
                id="product-unit-supply"
                v-model="form.productSupplyId"
                :error="form.errors.productSupplyId"
                :items="supplyOptions"
                label="Поставка"
                placeholder="Без поставки"
                variant="standard"
            />
            <Input
                id="product-unit-sowing-date"
                v-model="form.sowingDate"
                :error="form.errors.sowingDate"
                label="Дата посева"
                type="date"
                variant="standard"
            />
            <Input
                id="product-unit-qr-code"
                v-model="form.qrCode"
                :error="form.errors.qrCode"
                hint="Если указан, значение должно быть уникальным."
                label="QR-код"
                placeholder="Оставьте пустым для генерации позже"
                variant="standard"
            />
            <Checkbox
                id="product-unit-reserved"
                v-model="form.reserved"
                :error="form.errors.reserved"
                description="Единица недоступна для других заказов"
                text="Зарезервировано"
                variant="standard"
            />
            <div class="sm:col-span-2">
                <Input
                    id="product-unit-comments"
                    v-model="form.comments"
                    :error="form.errors.comments"
                    label="Комментарии"
                    multiline
                    variant="standard"
                />
            </div>
        </div>
        <div
            class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:px-8"
        >
            <Link
                class="inline-flex h-11 items-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 hover:bg-slate-100"
                href="/admin/product-units"
            >
                Отмена
            </Link>
            <Button
                :disabled="form.processing"
                class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm"
                secondary
                :text="form.processing ? 'Сохранение…' : 'Сохранить изменения'"
                type="submit"
            />
        </div>
    </form>
</template>

<script lang="ts" setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import type {
    ProductOption,
    ProductSupply,
    ProductUnitFormData,
    ProductUnitStatus,
} from '@/types/inventory';
import type { Warehouse } from '@/types/warehouse';

const props = defineProps<{
    initial: ProductUnitFormData;
    submitUrl: string;
    products: ProductOption[];
    warehouses: Warehouse[];
    statuses: ProductUnitStatus[];
    supplies: ProductSupply[];
}>();
const form = useForm<ProductUnitFormData>({ ...props.initial });
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
        label: `Поставка ${supply.id.slice(0, 8)} · ${supply.actualQuantity} шт.`,
    })),
);
const submit = () => form.put(props.submitUrl, { preserveScroll: true });
</script>

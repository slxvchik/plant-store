<template>
    <form class="product-unit-form" @submit.prevent="submit">
        <div class="product-unit-form__grid">
            <div class="product-unit-form__wide">
                <Select
                    id="product-unit-offer"
                    v-model="form.offerId"
                    :error="form.errors.offerId"
                    :items="offerOptions"
                    label="Товар / торговое предложение"
                    placeholder="Выберите предложение"
                    required
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
            />
            <Select
                id="product-unit-status"
                v-model="form.productUnitStatusId"
                :error="form.errors.productUnitStatusId"
                :items="statusOptions"
                label="Статус"
                placeholder="Выберите статус"
                required
            />
            <Select
                id="product-unit-supply"
                v-model="form.productSupplyId"
                :error="form.errors.productSupplyId"
                :items="supplyOptions"
                label="Поставка"
                placeholder="Без поставки"
            />
            <Input
                id="product-unit-sowing-date"
                v-model="form.sowingDate"
                :error="form.errors.sowingDate"
                label="Дата посева"
                type="date"
            />
            <Input
                id="product-unit-qr-code"
                v-model="form.qrCode"
                :error="form.errors.qrCode"
                hint="Если указан, значение должно быть уникальным."
                label="QR-код"
                placeholder="Оставьте пустым для генерации позже"
            />
            <Checkbox
                id="product-unit-reserved"
                v-model="form.reserved"
                :error="form.errors.reserved"
                description="Единица недоступна для других заказов"
                text="Зарезервировано"
            />
            <div class="product-unit-form__wide">
                <Textarea
                    id="product-unit-comments"
                    v-model="form.comments"
                    :error="form.errors.comments"
                    label="Комментарии"
                />
            </div>
        </div>
        <div class="product-unit-form__footer">
            <Link class="product-unit-form__cancel" href="/admin/product-units">
                Отмена
            </Link>
            <Button
                :disabled="form.processing"
                auto-width
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
import Textarea from '@/components/Textarea.vue';
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

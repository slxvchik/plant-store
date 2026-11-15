<template>
    <div class="w-full space-y-6">
        <AdminPageHeader
            back-url="/admin/product-units"
            description="Создайте одну единицу вручную или сформируйте партию с пустыми QR-кодами."
            eyebrow="Складской учёт"
            title="Создание единиц товара"
        />
        <div class="grid grid-cols-2 rounded-xl bg-slate-100 p-1">
            <button
                :class="mode === 'batch' ? activeTab : tab"
                type="button"
                @click="mode = 'batch'"
            >
                Партия
            </button>
            <button
                :class="mode === 'single' ? activeTab : tab"
                type="button"
                @click="mode = 'single'"
            >
                Одна единица
            </button>
        </div>
        <form
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
            @submit.prevent="submit"
        >
            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-8">
                <div class="sm:col-span-2">
                    <Select
                        v-model="form.offerId"
                        :error="form.errors.offerId"
                        :items="offerOptions"
                        label="Товар / торговое предложение"
                        placeholder="Выберите предложение"
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
                <Input
                    v-else
                    v-model="form.qrCode"
                    :error="form.errors.qrCode"
                    label="QR-код"
                    placeholder="Можно заполнить позже"
                />
                <Checkbox
                    v-if="mode === 'single'"
                    v-model="form.reserved"
                    description="Единица будет недоступна для других заказов"
                    text="Зарезервировано"
                />
                <div
                    v-else
                    class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-800"
                >
                    <span class="block font-semibold">
                        Будет создано: {{ form.quantity || 0 }} шт.
                    </span>
                    <span class="mt-1 block text-emerald-600">
                        QR-коды останутся пустыми.
                    </span>
                </div>
                <div class="sm:col-span-2">
                    <Input
                        v-model="form.comments"
                        :error="form.errors.comments"
                        label="Комментарии"
                        multiline
                        placeholder="Общий комментарий для создаваемых записей"
                    />
                </div>
            </div>
            <div
                class="flex items-center justify-between gap-4 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:px-8"
            >
                <p class="text-xs text-slate-500">
                    Все записи создаются в одной транзакции.
                </p>
                <Button
                    :disabled="form.processing"
                    :text="form.processing ? 'Создание…' : mode === 'batch' ? `Сгенерировать ${form.quantity || 0} шт.` : 'Создать единицу'"
                    class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm"
                    secondary
                    type="submit"
                />
            </div>
        </form>
    </div>
</template>
<script lang="ts" setup>
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Select from '@/components/Select.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import type { ProductOption, ProductSupply, ProductUnitStatus } from '@/types/inventory.ts';
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
    qrCode: string | null;
};
const mode = ref<'batch' | 'single'>('batch');
const tab =
    'rounded-lg px-4 py-2.5 text-sm font-medium text-slate-500 transition';
const activeTab =
    'rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm';
const form = useForm<UnitCreateForm>({
    quantity: 10,
    productSupplyId: null,
    offerId: null,
    warehouseId: '',
    reserved: false,
    sowingDate: null,
    productUnitStatusId: '',
    comments: '',
    qrCode: null,
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
            qrCode: data.qrCode,
        })).post('/admin/product-units');
    }
};
</script>

<template>
    <div class="flex flex-col gap-5">
        <p v-if="form.id">#{{ form.id }}</p>
        <Input
            id="offer_id"
            v-model="form.sku"
            :disabled="disabled"
            :error="form.errors.sku"
            label="Артикул"
        />
        <div class="w-fit">
            <Checkbox
                id="offer_active"
                v-model="form.active"
                :disabled="disabled"
                text="Активность"
            />
        </div>
        <Input
            id="offer_sort"
            v-model.number="form.sort"
            :disabled="disabled"
            label="Сортировка"
            type="number"
        />
        <Input
            id="offer_description"
            v-model="form.description"
            :disabled="disabled"
            label="Описание"
            multiline
        />
        <Input
            id="offer_price"
            v-model.number="form.price"
            :disabled="disabled"
            :error="form.errors.price"
            label="Цена (в копейках)"
            type="number"
        />
        <Input
            id="offer_form_factor"
            v-model="form.formFactor"
            :disabled="disabled"
            label="Фактор"
            type="text"
        />
        <Input
            id="offer_size"
            v-model="form.size"
            :disabled="disabled"
            label="Размер"
            type="text"
        />
        <Input
            id="offer_age"
            v-model.number="form.age"
            :disabled="disabled"
            label="Возраст"
            type="number"
        />
        <Input
            id="offer_sowing_date"
            v-model="form.sowingDate"
            :disabled="disabled"
            label="Дата"
            type="date"
        />
        <ImageUpload
            id="offer_images"
            v-model="form.images"
            :disabled="disabled"
            label="Изображения"
            multiple
            type="image"
        />
        <div v-if="warehouses.length" class="flex flex-col gap-4">
            <h2 class="text-2xl text-text-title">Наличие на складах</h2>
            <div
                v-for="warehouse in warehouses"
                :key="warehouse.id"
                class="mb-4 grid grid-cols-3 gap-5"
            >
                <div
                    class="w-full self-center text-sm font-medium text-gray-700"
                >
                    {{ warehouse.address }}
                </div>
                <template v-for="stock in form.stocks" :key="stock.warehouseId">
                    <template v-if="stock.warehouseId === warehouse.id">
                        <Input
                            :id="`${warehouse.id}-quantity`"
                            v-model.number="stock.quantity"
                            :disabled="disabled"
                            label="Доступное кол-во для покупки"
                            type="number"
                        />
                        <Input
                            :id="`${warehouse.id}-reserved`"
                            v-model.number="stock.reserved"
                            :disabled="disabled"
                            label="Зарезервированное кол-во товара"
                            type="number"
                        />
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { InertiaForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import Checkbox from '@/components/Checkbox.vue';
import ImageUpload from '@/components/ImageUpload.vue';
import Input from '@/components/Input.vue';
import type { OfferFormState } from '@/types/product.ts';
import type { Warehouse } from '@/types/warehouse.ts';

interface Props {
    warehouses: Warehouse[];
    disabled?: boolean;
}

const props = defineProps<Props>();
const form = defineModel<InertiaForm<OfferFormState>>('form', {
    required: true,
});

watch(
    () => props.warehouses,
    (warehouses) => {
        form.value.stocks = warehouses.map((warehouse) => {
            const existing = form.value.stocks?.find(
                (stock) => stock.warehouseId === warehouse.id,
            );

            return (
                existing ?? {
                    warehouseId: warehouse.id,
                    quantity: 0,
                    reserved: 0,
                }
            );
        });
    },
    { immediate: true, deep: true },
);
</script>

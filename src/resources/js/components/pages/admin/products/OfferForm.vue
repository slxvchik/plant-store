<template>
    <div class="flex flex-col gap-5">
        <p v-if="id">#{{ id }}</p>
        <Input id="offer_id" label="Артикул" v-model="sku" />
        <Checkbox id="offer_active" text="Активность" v-model="active" />
        <Input
            id="offer_sort"
            label="Сортировка"
            type="number"
            v-model="sort"
            required
        />
        <Textarea
            id="offer_description"
            label="Описание"
            v-model="description"
        />
        <Input
            id="offer_price"
            label="Цена"
            type="number"
            v-model="price"
            required
        />
        <Input
            id="offer_form_factor"
            label="Фактор"
            type="text"
            v-model="formFactor"
        />
        <Input id="offer_size" label="Размер" type="text" v-model="size" />
        <Input id="offer_age" label="Возраст" type="text" v-model="age" />
        <Input id="offer_age" label="Дата" type="text" v-model="sowingDate" />
        <FileUpload id="offer_images" type="image" v-model="images" />
        <div class="flex flex-col gap-4">
            <h2 class="text-2xl text-text-title">Наличие на складах</h2>
            <div
                v-for="(warehouse, index) in allWarehouses"
                :key="warehouse.id"
                class="mb-4 grid grid-cols-3 gap-5"
            >
                <div
                    class="w-full self-center text-sm font-medium text-gray-700"
                >
                    {{ warehouse.address }}
                </div>

                <Input
                    v-if="stocks[index]"
                    :id="`${warehouse.id}-quantity`"
                    label="Доступное кол-во для покупки"
                    v-model.number="stocks[index].quantity"
                />

                <Input
                    v-if="stocks[index]"
                    :id="`${warehouse.id}-reserved`"
                    label="Зарезервированное кол-во товара"
                    v-model.number="stocks[index].reserved"
                />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { watchEffect } from 'vue';
import Checkbox from '@/components/Checkbox.vue';
import FileUpload from '@/components/FileUpload.vue';
import Input from '@/components/Input.vue';
import Textarea from '@/components/Textarea.vue';
import type { UploadableImage } from '@/types';
import type { StockFormState } from '@/types/form/product.ts';
import type { Warehouse } from '@/types/warehouse.ts';

interface Props {
    allWarehouses: Warehouse[];
}

const props = defineProps<Props>();

const id = defineModel<string | undefined>('id', {
    type: String,
    default: undefined,
});
const active = defineModel('active', { type: Boolean, default: false });
const sku = defineModel('sku', { type: String, default: '' });
const sort = defineModel('sort', { type: Number, default: 500 });
const description = defineModel<string | undefined>('description', {
    type: String,
    default: '',
});
const price = defineModel('price', { type: Number, default: 0 });
const formFactor = defineModel('formFactor', { type: String, default: '' });
const size = defineModel('size', { type: String, default: '' });
const age = defineModel('age', { type: Number, default: '' });
const sowingDate = defineModel('sowingDate', { type: String, default: '' });
const images = defineModel<UploadableImage[] | null>('images', {
    default: () => [],
});
const stocks = defineModel<StockFormState[]>('stocks', { default: () => [] });

watchEffect(() => {
    stocks.value = props.allWarehouses.map((warehouse) => {
        const existingStock = stocks.value.find(
            (s) => s.warehouseId === warehouse.id,
        );

        return (
            existingStock || {
                warehouseId: warehouse.id,
                quantity: 0,
                reserved: 0,
            }
        );
    });
});
</script>

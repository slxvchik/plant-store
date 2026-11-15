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
            id="offer_available_quantity"
            v-model.number="form.stockQuantity"
            :disabled="disabled"
            :error="form.errors.stockQuantity"
            label="Доступное кол-во"
            type="number"
        />
        <ImageUpload
            id="offer_images"
            v-model="form.images"
            :disabled="disabled"
            label="Изображения"
            multiple
            type="image"
        />
    </div>
</template>

<script lang="ts" setup>
import type { InertiaForm } from '@inertiajs/vue3';
import Checkbox from '@/components/Checkbox.vue';
import ImageUpload from '@/components/ImageUpload.vue';
import Input from '@/components/Input.vue';
import type { OfferFormState } from '@/types/product.ts';
import type { Warehouse } from '@/types/warehouse.ts';

interface Props {
    warehouses: Warehouse[];
    disabled?: boolean;
}

defineProps<Props>();
const form = defineModel<InertiaForm<OfferFormState>>('form', {
    required: true,
});
</script>

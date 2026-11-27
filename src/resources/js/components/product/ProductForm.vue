<template>
    <div class="product-form">
        <p v-if="form.id">#{{ form.id }}</p>
        <Input
            id="name"
            v-model="form.name"
            :disabled="disabled"
            :error="errors?.name"
            label="Название"
        />
        <div class="product-form__checkbox">
            <Checkbox
                id="active"
                v-model="form.active"
                :disabled="disabled"
                :error="errors?.active"
                text="Активность"
            />
        </div>
        <Input
            id="alias"
            v-model="form.alias"
            :disabled="disabled"
            :error="errors?.alias"
            label="Алиас"
        />
        <Input
            id="sort"
            v-model.number="form.sort"
            :disabled="disabled"
            :error="errors?.sort"
            label="Сортировка"
            type="number"
        />
        <Textarea
            id="description"
            v-model="form.description"
            :disabled="disabled"
            :error="errors?.description"
            label="Описание"
        />
        <Select
            v-model="form.category"
            :disabled="disabled"
            :items="allCategories"
            label="Категории"
        />
        <ImageUpload
            id="images"
            v-model="form.images"
            :disabled="disabled"
            label="Изображения товара"
            multiple
            type="image"
        />
        <div class="product-form__checkbox">
            <Checkbox
                id="featured"
                v-model="form.featured"
                :disabled="disabled"
                :error="errors?.featured"
                text="Выводить на главной"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Checkbox from '@/components/Checkbox.vue';
import ImageUpload from '@/components/ImageUpload.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import Textarea from '@/components/Textarea.vue';
import type { ProductFormState } from '@/types/product.ts';
import type { SelectItem } from '@/types/select-item.ts';

interface Props {
    allCategories: SelectItem[];
    disabled?: boolean;
    errors?: Record<string, string | undefined>;
}

defineProps<Props>();
const form = defineModel<ProductFormState>({ required: true });
</script>

<template>
    <div class="flex flex-col gap-5">
        <p v-if="form.id">#{{ form.id }}</p>
        <Input
            id="name"
            v-model="form.name"
            label="Название"
            :error="errors?.name"
            :disabled="disabled"
            rules="required"
        />
        <Checkbox
            id="active"
            v-model="form.active"
            text="Активность"
            :error="errors?.active"
            :disabled="disabled"
        />
        <Input
            id="alias"
            v-model="form.alias"
            label="Алиас"
            :error="errors?.alias"
            rules="required|min:4"
            :disabled="disabled"
        />
        <Input
            id="sort"
            v-model.number="form.sort"
            label="Сортировка"
            type="number"
            :error="errors?.sort"
            rules="required|positiveNumber"
            :disabled="disabled"
        />
        <Textarea
            id="description"
            v-model="form.description"
            label="Описание"
            :error="errors?.description"
            :disabled="disabled"
        />
        <Select
            v-model="form.categories"
            :items="allCategories"
            label="Категории"
            placeholder="Выберите категории"
            multiple
            :disabled="disabled"
        />
        <ImageUpload
            id="images"
            v-model="form.images"
            label="Изображения товара"
            type="image"
            :disabled="disabled"
            multiple
        />
    </div>
</template>

<script setup lang="ts">
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

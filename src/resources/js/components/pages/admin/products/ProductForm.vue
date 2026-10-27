<template>
    <div class="flex flex-col gap-5">
        <p v-if="form.id">#{{ form.id }}</p>
        <Input
            id="name"
            v-model="form.name"
            label="Название"
            :error="errors?.name"
            rules="required"
        />
        <Checkbox
            id="active"
            v-model="form.active"
            text="Активность"
            :error="errors?.active"
        />
        <Input
            id="alias"
            v-model="form.alias"
            label="Алиас"
            :error="errors?.alias"
            rules="required|min:4"
        />
        <Input
            id="sort"
            v-model.number="form.sort"
            label="Сортировка"
            type="number"
            :error="errors?.sort"
            rules="required|positiveNumber"
        />
        <Textarea
            id="description"
            v-model="form.description"
            label="Описание"
            :error="errors?.description"
        />
        <Select
            v-model="form.categories"
            :items="allCategories"
            label="Категории"
            placeholder="Выберите категории"
            multiple
        />
        <FileUpload
            id="images"
            v-model="form.images"
            label="Изображения товара"
            type="image"
        />
    </div>
</template>

<script setup lang="ts">
import Checkbox from '@/components/Checkbox.vue';
import FileUpload from '@/components/FileUpload.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import Textarea from '@/components/Textarea.vue';
import type { ProductFormState } from '@/types/form/product';
import type { SelectItem } from '@/types/selectItem';

interface Props {
    allCategories: SelectItem[];
    errors?: Record<string, string | undefined>;
}

defineProps<Props>();
const form = defineModel<ProductFormState>({ required: true });
</script>

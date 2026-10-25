<template>
    <div class="flex flex-col gap-5">
        <p v-if="id">#{{ id }}</p>
        <Input id="name" label="Название" type="text" v-model="name" required />
        <Checkbox id="active" text="Активность" v-model="active" />
        <Input id="alias" label="Алиас" type="text" v-model="alias" required />
        <Input
            id="sort"
            label="Сортировка"
            type="number"
            v-model="sort"
            required
        />
        <Textarea id="description" label="Описание" v-model="description" />
        <Select
            :items="allCategories"
            v-model="categories"
            label="Категории"
            placeholder="Выберите категории"
            :multiple="true"
        />
        <FileUpload
            id="images"
            label="Изображения товара"
            v-model="images"
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
import type { UploadableImage } from '@/types';
import type { SelectVal } from '@/types/select.ts';

interface Props {
    allCategories: SelectVal[];
}

defineProps<Props>();

const id = defineModel<string | undefined>('id', {
    type: String,
    default: undefined,
});
const name = defineModel('name', { type: String, default: '' });
const active = defineModel('active', { type: Boolean, default: false });
const alias = defineModel('alias', { type: String, default: '' });
const sort = defineModel('sort', { type: Number, default: 500 });
const description = defineModel('description', { type: String, default: '' });
const categories = defineModel<string[]>('categories', { default: () => [] });
const images = defineModel<UploadableImage[] | null>('images', {
    default: () => [],
});
</script>

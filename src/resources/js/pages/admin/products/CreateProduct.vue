<template>
    <div class="flex flex-col gap-5">
        <Link :href="AdminProduct.index.url()" text="Назад" />
        <h1 class="text-4xl text-text-title">Создание товара</h1>
        <form class="flex flex-col gap-5">
            <Input
                id="name"
                label="Название"
                type="text"
                v-model="productName"
            />
            <Checkbox id="active" text="Активность" v-model="productActive" />
            <Input
                id="alias"
                label="Алиас"
                type="text"
                v-model="productAlias"
            />
            <Input
                id="sort"
                label="Сортировка"
                type="number"
                v-model="productSort"
            />
            <Textarea
                id="description"
                label="Описание"
                v-model="productDescription"
            />
            <Select
                :items="allProductCategories"
                v-model="productCategories"
                label="Категории"
                placeholder="Выберите категории"
                :multiple="true"
            />
            <FileUpload
                id="images"
                label="Изображения товара"
                v-model="productFiles"
                type="image"
            />
            <div class="max-w-80">
                <Button type="button" text="Создать" @click="create" />
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import FileUpload from '@/components/FileUpload.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import Select from '@/components/Select.vue';
import Textarea from '@/components/Textarea.vue';
import AdminProduct from '@/routes/admin/products';
import type { Category } from '@/types';

defineOptions({
    layout: AdminLayout,
});

interface Props {
    categories: Category[];
}

const props = defineProps<Props>();

const allProductCategories = computed(() => {
    return props.categories.map((category) => ({
        label: category.name,
        value: category.id,
    }));
});

const productActive = ref(false);
const productAlias = ref('');
const productSort = ref(500);
const productName = ref('');
const productDescription = ref('');
const productCategories = ref([]);
const productFiles = ref([]);

const create = () => {
    const product = {
        active: productActive.value,
        alias: productAlias.value,
        sort: productSort.value,
        name: productName.value,
        description: productDescription.value,
        categories: productCategories.value,
        images: productFiles.value,
    };
    router.post(AdminProduct.store.url(), product);
};
</script>

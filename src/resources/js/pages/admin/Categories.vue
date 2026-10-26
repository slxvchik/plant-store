<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Категории</h1>
        <div class="max-w-80"><Button text="Создать" secondary @click="openCreateModal" /></div>
    </div>
    <div class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase">
            <div class="p-4">Id</div><div class="p-4">Родительская категория</div><div class="p-4">Алиас</div>
            <div class="p-4">Название</div><div class="p-4">Сортировка</div><div class="p-4">Активность</div><div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div v-for="category in categoriesPage.items" :key="category.id" class="grid grid-cols-7 transition-colors hover:bg-gray-50">
                <div class="p-4 font-medium text-gray-900">#{{ category.id }}</div>
                <div class="p-4 whitespace-nowrap">{{ category.parent?.name ?? '-' }}</div>
                <div class="truncate p-4">{{ category.alias }}</div><div class="p-4 whitespace-nowrap">{{ category.name }}</div>
                <div class="p-4">{{ category.sort }}</div><div class="p-4">{{ category.active }}</div>
                <div class="flex flex-wrap gap-2 p-4">
                    <Button text="Редактировать" class="bg-yellow-400 break-all hover:bg-yellow-500" @click="openEditModal(category)" />
                    <Button text="Удалить" class="bg-red-400 hover:bg-red-500" @click="destroy(category.id)" />
                </div>
            </div>
        </div>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать категорию' : 'Создать категорию'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Select v-model="form.parentId" :items="categoriesSelect" label="Родительская категория" nullable />
            <Input id="alias" v-model="form.alias" placeholder="category-1" label="Алиас" :error="form.errors.alias" required />
            <Input id="name" v-model="form.name" placeholder="Категория 1" label="Название" :error="form.errors.name" required />
            <Input id="sort" v-model.number="form.sort" placeholder="500" label="Сортировка" type="number" :error="form.errors.sort" required />
            <Checkbox id="active" text="Активность" v-model="form.active" :error="form.errors.active" />
            <Button type="submit" secondary :disabled="form.processing" :text="isEditMode ? 'Сохранить' : 'Создать'" class="relative left-[50%] max-w-80 translate-x-[-50%]" />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import Select from '@/components/Select.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminCategories from '@/routes/admin/categories';
import type { Category } from '@/types/category';
import type { PageResponse } from '@/types/page-response';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    categoriesPage: PageResponse<Category>;
    categories: Category[];
}>();

type CategoryForm = {
    parentId: string | null;
    alias: string;
    sort: number;
    name: string;
    active: boolean;
};
const createData = (): CategoryForm => ({
    parentId: null, alias: '', sort: 500, name: '', active: false,
});
const {
    form, isFormPopupOpen, isEditMode, editingId, openCreateModal, openEditModal, submit, destroy,
} = useAdminCrudForm<CategoryForm, Category>({
    createData,
    editData: (category) => ({
        parentId: category.parent?.id ?? null,
        alias: category.alias,
        sort: category.sort,
        name: category.name,
        active: category.active,
    }),
    routes: {
        store: () => AdminCategories.store.url(),
        update: (id) => AdminCategories.update.url(id),
        destroy: (id) => AdminCategories.destroy.url(id),
    },
});
const categoriesSelect = computed(() =>
    props.categories
        .filter((category) => category.id !== editingId.value)
        .map((category) => ({ label: category.name, value: category.id })),
);
</script>

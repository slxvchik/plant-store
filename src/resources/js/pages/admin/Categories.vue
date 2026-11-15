<template>
    <div class="space-y-6">
        <AdminPageHeader title="Категории" eyebrow="Каталог" description="Иерархия каталога и порядок отображения разделов."><template #actions><Button text="Добавить категорию" secondary class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm shadow-sm" @click="openCreateModal" /></template></AdminPageHeader>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><div class="overflow-x-auto"><table class="w-full min-w-[1000px] text-left text-sm"><thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500"><tr><th class="px-5 py-4">ID</th><th class="px-5 py-4">Родитель</th><th class="px-5 py-4">Алиас</th><th class="px-5 py-4">Название</th><th class="px-5 py-4">Сортировка</th><th class="px-5 py-4">Активность</th><th class="px-5 py-4 text-right">Действия</th></tr></thead><tbody class="divide-y divide-slate-100"><tr v-for="category in categoriesPage.items" :key="category.id" class="transition hover:bg-slate-50"><td class="px-5 py-4 font-mono text-xs text-slate-400">#{{ category.id.slice(0, 8) }}</td><td class="px-5 py-4 text-slate-500">{{ category.parent?.name ?? 'Корневая' }}</td><td class="px-5 py-4 font-medium text-slate-600">{{ category.alias }}</td><td class="px-5 py-4 font-semibold text-slate-900">{{ category.name }}</td><td class="px-5 py-4 text-slate-500">{{ category.sort }}</td><td class="px-5 py-4"><Badge :label="category.active ? 'Активна' : 'Скрыта'" :tone="category.active ? 'success' : 'neutral'" /></td><td class="px-5 py-4"><div class="flex justify-end gap-2"><button type="button" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-emerald-200 hover:text-emerald-700" @click="openEditModal(category)">Изменить</button><button type="button" class="rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50" @click="destroy(category.id)">Удалить</button></div></td></tr><tr v-if="categoriesPage.items.length === 0"><td colspan="7" class="px-5 py-16 text-center text-slate-500">Категории ещё не созданы.</td></tr></tbody></table></div></section>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать категорию' : 'Создать категорию'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Select v-model="form.parentId" :items="categoriesSelect" label="Родительская категория" nullable />
            <Input id="alias" v-model="form.alias" label="Алиас" @update:modelValue="validateField && validateField('alias', form.alias)" :error="form.errors.alias" />
            <Input id="name" v-model="form.name" label="Название" @update:modelValue="validateField && validateField('name', form.name)" :error="form.errors.name" />
            <Input id="sort" v-model.number="form.sort" label="Сортировка" type="number" @update:modelValue="validateField && validateField('sort', form.sort)" :error="form.errors.sort" />
            <Checkbox id="active" text="Активность" v-model="form.active" :error="form.errors.active" />
            <div class="flex justify-end border-t border-slate-100 pt-5"><Button type="submit" secondary :disabled="form.processing" :text="isEditMode ? 'Сохранить' : 'Создать'" class="!w-auto !rounded-xl !px-5 !text-sm" /></div>
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import Select from '@/components/Select.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminCategories from '@/routes/admin/categories';
import type { Category } from '@/types/category.ts';
import type { Page } from '@/types/pagination.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    categoriesPage: Page<Category>;
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
    parentId: null,
    alias: '',
    sort: 500,
    name: '',
    active: false,
});
const categoryValidator = (field: keyof CategoryForm, value: any) => {
    switch (field) {
        case 'name':
            return validate(
                value,
                'required',
                'Название категории обязательно',
            );
        case 'alias':
            return validate(value, 'required', 'Алиас обязателен');
        case 'sort':
            return validate(
                value,
                'required',
                'Сортировка для категории обязательна',
            );
        default:
            return null;
    }
};
const {
    form,
    formValidator,
    isFormPopupOpen,
    isEditMode,
    editingId,
    openCreateModal,
    openEditModal,
    submit,
    destroy,
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
    validator: categoryValidator,
});
const validateField = formValidator?.validateField;
const categoriesSelect = computed(() =>
    props.categories
        .filter((category) => category.id !== editingId.value)
        .map((category) => ({ label: category.name, value: category.id })),
);
</script>

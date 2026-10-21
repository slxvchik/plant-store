<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Категории</h1>
        <div class="max-w-80">
            <Button
                text="Создать"
                class="rounded-lg"
                @click="openCreateModal"
            />
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-6 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Id</div>
            <div class="p-4">Алиас</div>
            <div class="p-4">Название</div>
            <div class="p-4">Сортировка</div>
            <div class="p-4">Активность</div>
            <div class="p-4">Действие</div>
        </div>

        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="category in categoriesPage.items"
                :key="category.id"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">
                    #{{ category.id }}
                </div>
                <div class="truncate p-4">{{ category.alias }}</div>
                <div class="p-4 whitespace-nowrap">{{ category.name }}</div>
                <div class="p-4">{{ category.sort }}</div>
                <div class="p-4">{{ category.active }}</div>
                <div class="flex flex-wrap gap-2 p-4">
                    <Button
                        text="Редактировать"
                        class="rounded-lg bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(category)"
                    />
                    <Button
                        text="Удалить"
                        class="rounded-lg bg-red-400 hover:bg-red-500"
                        @click="deleteCategory(category.id)"
                    />
                </div>
            </div>
        </div>
    </div>

    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать тег' : 'Создать тег'"
    >
        <form class="flex w-full flex-col">
            <Input
                id="alias"
                placeholder="category-1"
                label="Алиас"
                v-model="categoryAlias"
            />
            <Input
                id="name"
                placeholder="Категория 1"
                label="Название"
                class="mt-5"
                v-model="categoryName"
            />
            <Input
                id="name"
                placeholder="500"
                label="Сортировка"
                class="mt-5"
                type="number"
                v-model="categorySort"
            />
            <Checkbox
                id="active"
                placeholder="Тег 1"
                text="Активность"
                class="mt-5"
                v-model="categoryActive"
            />
            <Button
                type="button"
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] mt-5 max-w-80 translate-x-[-50%] rounded-lg"
                @click="isEditMode ? updateCategory() : createCategory()"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import AdminCategories from '@/routes/admin/categories';
import type { Category } from '@/types';
import type { PageResponse } from '@/types/page-response';

defineOptions({
    layout: AdminLayout,
});

defineProps({
    auth: {
        type: Object,
        required: false,
    },
    categoriesPage: {
        type: Object as () => PageResponse<Category>,
        required: true,
    },
});

const isFormPopupOpen = ref(false);
const isEditMode = ref(false);

const categoryId = ref<string | undefined>(undefined);
const categoryAlias = ref('');
const categorySort = ref<bigint>(BigInt(500));
const categoryName = ref('');
const categoryActive = ref(false);

const openCreateModal = () => {
    isEditMode.value = false;
    categoryId.value = undefined;
    categoryAlias.value = '';
    categorySort.value = BigInt(500);
    categoryName.value = '';
    categoryActive.value = false;
    isFormPopupOpen.value = true;
};

const openEditModal = (category: Category) => {
    isEditMode.value = true;
    categoryId.value = category.id;
    categoryAlias.value = category.alias;
    categorySort.value = category.sort;
    categoryName.value = category.name;
    categoryActive.value = category.active;
    isFormPopupOpen.value = true;
};

const createCategory = () => {
    const category = {
        alias: categoryAlias.value,
        sort: categorySort.value,
        name: categoryName.value,
        active: categoryActive.value,
    };
    router.post(AdminCategories.store.url(), category, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            categoryId.value = undefined;
            categoryAlias.value = '';
            categorySort.value = BigInt(500);
            categoryName.value = '';
            categoryActive.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const updateCategory = () => {
    if (categoryId.value === undefined) {
        return;
    }

    const category = {
        alias: categoryAlias.value,
        sort: categorySort.value,
        name: categoryName.value,
        active: categoryActive.value,
    };

    router.put(AdminCategories.update.url(categoryId.value), category, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            categoryId.value = undefined;
            categoryAlias.value = '';
            categorySort.value = BigInt(500);
            categoryName.value = '';
            categoryActive.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const deleteCategory = (categoryId: string) => {
    router.delete(AdminCategories.destroy.url(categoryId), {
        onSuccess: () => {},
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>

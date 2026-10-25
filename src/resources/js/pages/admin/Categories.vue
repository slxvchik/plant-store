<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Категории</h1>
        <div class="max-w-80">
            <Button text="Создать" secondary @click="openCreateModal" />
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-7 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Id</div>
            <div class="p-4">Родительская категория</div>
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
                class="grid grid-cols-7 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">
                    #{{ category.id }}
                </div>
                <div class="p-4 whitespace-nowrap">
                    {{ category.parent?.name ?? '-' }}
                </div>
                <div class="truncate p-4">{{ category.alias }}</div>
                <div class="p-4 whitespace-nowrap">{{ category.name }}</div>
                <div class="p-4">{{ category.sort }}</div>
                <div class="p-4">{{ category.active }}</div>
                <div class="flex flex-wrap gap-2 p-4">
                    <Button
                        text="Редактировать"
                        class="bg-yellow-400 break-all hover:bg-yellow-500"
                        @click="openEditModal(category)"
                    />
                    <Button
                        text="Удалить"
                        class="bg-red-400 hover:bg-red-500"
                        @click="deleteCategory(category.id)"
                    />
                </div>
            </div>
        </div>
    </div>

    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать категорию' : 'Создать категорию'"
    >
        <form class="flex w-full flex-col gap-5">
            <Select
                :items="categoriesSelect"
                label="Родительская категория"
                v-model="categoryParentId"
                :nullable="true"
            />
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
                v-model="categoryName"
            />
            <Input
                id="name"
                placeholder="500"
                label="Сортировка"
                type="number"
                v-model="categorySort"
            />
            <Checkbox
                id="active"
                placeholder="500"
                text="Активность"
                v-model="categoryActive"
            />
            <Button
                type="button"
                secondary
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
                @click="isEditMode ? updateCategory() : createCategory()"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import Select from '@/components/Select.vue';
import AdminCategories from '@/routes/admin/categories';
import type { Category } from '@/types';
import type { PageResponse } from '@/types/page-response';

defineOptions({
    layout: AdminLayout,
});

interface Props {
    auth?: object;
    categoriesPage: PageResponse<Category>;
    categories: Category[];
}

const props = defineProps<Props>();

const categoriesSelect = computed(() => {
    return props.categories
        .filter((category) => category.id !== categoryId.value)
        .map((category) => ({
            label: category.name,
            value: category.id,
        }));
});

const isFormPopupOpen = ref(false);
const isEditMode = ref(false);

const categoryId = ref<string | undefined>(undefined);
const categoryParentId = ref<string | undefined>(undefined);
const categoryAlias = ref('');
const categorySort = ref<bigint>(BigInt(500));
const categoryName = ref('');
const categoryActive = ref(false);

const openCreateModal = () => {
    isEditMode.value = false;
    categoryId.value = undefined;
    categoryParentId.value = undefined;
    categoryAlias.value = '';
    categorySort.value = BigInt(500);
    categoryName.value = '';
    categoryActive.value = false;
    isFormPopupOpen.value = true;
};

const openEditModal = (category: Category) => {
    isEditMode.value = true;
    categoryId.value = category.id;
    categoryParentId.value = category.parent?.id;
    categoryAlias.value = category.alias;
    categorySort.value = category.sort;
    categoryName.value = category.name;
    categoryActive.value = category.active;
    isFormPopupOpen.value = true;
};

const createCategory = () => {
    const category = {
        parentId: categoryParentId.value,
        alias: categoryAlias.value,
        sort: categorySort.value,
        name: categoryName.value,
        active: categoryActive.value,
    };
    router.post(AdminCategories.store.url(), category, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            categoryId.value = undefined;
            categoryParentId.value = undefined;
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
        parentId: categoryParentId.value,
        alias: categoryAlias.value,
        sort: categorySort.value,
        name: categoryName.value,
        active: categoryActive.value,
    };

    router.put(AdminCategories.update.url(categoryId.value), category, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            categoryId.value = undefined;
            categoryParentId.value = undefined;
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

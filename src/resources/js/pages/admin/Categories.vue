<template>
    <div class="categories">
        <AdminPageHeader
            description="Иерархия каталога и порядок отображения разделов."
            eyebrow="Каталог"
            title="Категории"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Добавить категорию"
                    @click="openCreateModal"
                />
            </template>
        </AdminPageHeader>
        <Table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Родитель</th>
                    <th>Алиас</th>
                    <th>Название</th>
                    <th>Сортировка</th>
                    <th>Активность</th>
                    <th class="categories__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categoriesPage.items" :key="category.id">
                    <td class="categories__id">
                        #{{ category.id.slice(0, 8) }}
                    </td>
                    <td class="categories__muted">
                        {{ category.parent?.name ?? 'Корневая' }}
                    </td>
                    <td class="categories__alias">{{ category.alias }}</td>
                    <td class="categories__name">{{ category.name }}</td>
                    <td class="categories__muted">{{ category.sort }}</td>
                    <td>
                        <Badge
                            :label="category.active ? 'Активна' : 'Скрыта'"
                            :tone="category.active ? 'success' : 'neutral'"
                        />
                    </td>
                    <td>
                        <div class="categories__actions">
                            <Button
                                auto-width
                                outline
                                small
                                text="Изменить"
                                type="button"
                                @click="openEditModal(category)"
                            />
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                type="button"
                                @click="destroy(category.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="categoriesPage.items.length === 0">
                    <td class="categories__empty" colspan="7">
                        Категории ещё не созданы.
                    </td>
                </tr>
            </tbody>
        </Table>
        <Modal
            v-model:open="isFormPopupOpen"
            :title="
                isEditMode ? 'Редактировать категорию' : 'Создать категорию'
            "
        >
            <form class="categories__form" @submit.prevent="submit">
                <Select
                    v-model="form.parentId"
                    :items="categoriesSelect"
                    label="Родительская категория"
                    nullable
                />
                <Input
                    id="alias"
                    v-model="form.alias"
                    :error="form.errors.alias"
                    label="Алиас"
                    @update:modelValue="
                        validateField && validateField('alias', form.alias)
                    "
                />
                <Input
                    id="name"
                    v-model="form.name"
                    :error="form.errors.name"
                    label="Название"
                    @update:modelValue="
                        validateField && validateField('name', form.name)
                    "
                />
                <Input
                    id="sort"
                    v-model.number="form.sort"
                    :error="form.errors.sort"
                    label="Сортировка"
                    type="number"
                    @update:modelValue="
                        validateField && validateField('sort', form.sort)
                    "
                />
                <Checkbox
                    id="active"
                    v-model="form.active"
                    :error="form.errors.active"
                    text="Активность"
                />
                <div class="categories__form-footer">
                    <Button
                        :disabled="form.processing"
                        :text="isEditMode ? 'Сохранить' : 'Создать'"
                        auto-width
                        secondary
                        type="submit"
                    />
                </div>
            </form>
        </Modal>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Modal from '@/components/Modal.vue';
import Select from '@/components/Select.vue';
import Table from '@/components/Table.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
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

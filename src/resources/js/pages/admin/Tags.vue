<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Теги</h1>
        <div class="max-w-80">
            <Button text="Создать" secondary @click="openCreateModal" />
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
                v-for="tag in tagsPage.items"
                :key="tag.id"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">#{{ tag.id }}</div>
                <div class="truncate p-4">{{ tag.alias }}</div>
                <div class="p-4">{{ tag.name }}</div>
                <div class="p-4 whitespace-nowrap">{{ tag.sort }}</div>
                <div class="p-4">{{ tag.active }}</div>
                <div class="flex flex-wrap gap-2 p-4">
                    <Button
                        text="Редактировать"
                        class="bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(tag)"
                    />
                    <Button
                        text="Удалить"
                        class="bg-red-400 hover:bg-red-500"
                        @click="destroy(tag.id)"
                    />
                </div>
            </div>
        </div>
    </div>
    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать тег' : 'Создать тег'"
    >
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input
                id="alias"
                v-model="form.alias"
                placeholder="tag-1"
                label="Алиас"
                :error="form.errors.alias"
                @update:modelValue="validateField('alias', form.alias)"
            />
            <Input
                id="name"
                v-model="form.name"
                placeholder="Тег 1"
                label="Название"
                :error="form.errors.name"
                @update:modelValue="validateField('name', form.name)"
            />
            <Input
                id="sort"
                v-model.number="form.sort"
                placeholder="500"
                label="Сортировка"
                type="number"
                :error="form.errors.sort"
                @update:modelValue="validateField('sort', form.sort)"
            />
            <Checkbox
                id="active"
                text="Активность"
                v-model="form.active"
                :error="form.errors.active"
            />
            <Button
                type="submit"
                secondary
                :disabled="form.processing"
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminTags from '@/routes/admin/tags';
import type { PageResponse } from '@/types/pageResponse';
import type { Tag } from '@/types/tag';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ tagsPage: PageResponse<Tag> }>();

type TagForm = Omit<Tag, 'id'>;
const createData = (): TagForm => ({
    alias: '',
    sort: 500,
    name: '',
    active: false,
});
const tagValidator = (field: keyof TagForm, value: any) => {
    switch (field) {
        case 'name':
            return validate(value, 'required', 'Название тега обязательно');
        case 'alias':
            return validate(value, 'required', 'Алиас обязателен');
        case 'sort':
            return validate(value, 'required', 'Сортировка для тега обязательна');
        default:
            return null;
    }
};
const {
    form,
    validateField,
    isFormPopupOpen,
    isEditMode,
    openCreateModal,
    openEditModal,
    submit,
    destroy,
} = useAdminCrudForm<TagForm, Tag>({
    createData,
    editData: ({ alias, sort, name, active }) => ({
        alias,
        sort,
        name,
        active,
    }),
    routes: {
        store: () => AdminTags.store.url(),
        update: (id) => AdminTags.update.url(id),
        destroy: (id) => AdminTags.destroy.url(id),
    },
    validator: tagValidator,
});
</script>

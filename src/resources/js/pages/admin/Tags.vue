<template>
    <div class="space-y-6">
        <AdminPageHeader title="Теги" eyebrow="Каталог" description="Управляйте метками для быстрого поиска и группировки товаров."><template #actions><Button text="Добавить тег" secondary class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm shadow-sm" @click="openCreateModal" /></template></AdminPageHeader>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><div class="overflow-x-auto"><table class="w-full min-w-[850px] text-left text-sm"><thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500"><tr><th class="px-5 py-4">ID</th><th class="px-5 py-4">Алиас</th><th class="px-5 py-4">Название</th><th class="px-5 py-4">Сортировка</th><th class="px-5 py-4">Активность</th><th class="px-5 py-4 text-right">Действия</th></tr></thead><tbody class="divide-y divide-slate-100"><tr v-for="tag in tagsPage.items" :key="tag.id" class="transition hover:bg-slate-50"><td class="px-5 py-4 font-mono text-xs text-slate-400">#{{ tag.id.slice(0, 8) }}</td><td class="px-5 py-4 font-medium text-slate-600">{{ tag.alias }}</td><td class="px-5 py-4 font-semibold text-slate-900">{{ tag.name }}</td><td class="px-5 py-4 text-slate-500">{{ tag.sort }}</td><td class="px-5 py-4"><Badge :label="tag.active ? 'Активен' : 'Скрыт'" :tone="tag.active ? 'success' : 'neutral'" /></td><td class="px-5 py-4"><div class="flex justify-end gap-2"><button type="button" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-emerald-200 hover:text-emerald-700" @click="openEditModal(tag)">Изменить</button><button type="button" class="rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50" @click="destroy(tag.id)">Удалить</button></div></td></tr><tr v-if="tagsPage.items.length === 0"><td colspan="6" class="px-5 py-16 text-center text-slate-500">Теги ещё не созданы.</td></tr></tbody></table></div></section>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать тег' : 'Создать тег'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input id="alias" v-model="form.alias" label="Алиас" :error="form.errors.alias" @update:modelValue="validateField && validateField('alias', form.alias)" />
            <Input id="name" v-model="form.name" label="Название" :error="form.errors.name" @update:modelValue="validateField && validateField('name', form.name)" />
            <Input id="sort" v-model.number="form.sort" label="Сортировка" type="number" :error="form.errors.sort" @update:modelValue="validateField && validateField('sort', form.sort)" />
            <Checkbox id="active" text="Активность" v-model="form.active" :error="form.errors.active" />
            <div class="flex justify-end border-t border-slate-100 pt-5"><Button type="submit" secondary :disabled="form.processing" :text="isEditMode ? 'Сохранить' : 'Создать'" class="!w-auto !rounded-xl !px-5 !text-sm" /></div>
        </form>
    </Popup>
</template>

<script setup lang="ts">
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminTags from '@/routes/admin/tags';
import type { Page } from '@/types/pagination.ts';
import type { Tag } from '@/types/tag.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ tagsPage: Page<Tag> }>();

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
            return validate(
                value,
                'required',
                'Сортировка для тега обязательна',
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
const validateField = formValidator?.validateField;
</script>

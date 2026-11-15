<template>
    <div class="space-y-6">
        <AdminPageHeader title="Новости" eyebrow="Контент" description="Публикации, порядок сортировки и видимость на сайте.">
            <template #actions><Button text="Добавить новость" secondary class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm" @click="openCreateModal" /></template>
        </AdminPageHeader>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"><tr><th class="px-5 py-4">ID</th><th class="px-5 py-4">Алиас</th><th class="px-5 py-4">Название</th><th class="px-5 py-4">Сортировка</th><th class="px-5 py-4">Активность</th><th class="px-5 py-4 text-right">Действия</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="newsItem in newsPage.items" :key="newsItem.id" class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-mono text-xs text-slate-400">#{{ newsItem.id.slice(0, 8) }}</td><td class="px-5 py-4 text-slate-600">{{ newsItem.alias }}</td><td class="px-5 py-4 font-semibold text-slate-900">{{ newsItem.name }}</td><td class="px-5 py-4 text-slate-500">{{ newsItem.sort }}</td><td class="px-5 py-4"><Badge :label="newsItem.active ? 'Активна' : 'Скрыта'" :tone="newsItem.active ? 'success' : 'neutral'" /></td>
                            <td class="px-5 py-4"><div class="flex justify-end gap-2"><Link :href="AdminNews.show.url(newsItem.id)" text="Открыть" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700" /><Button text="Изменить" class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-slate-600 hover:!bg-slate-100" @click="openEditModal(newsItem)" /><Button text="Удалить" class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-rose-600 hover:!bg-rose-50" @click="destroy(newsItem.id)" /></div></td>
                        </tr>
                        <tr v-if="newsPage.items.length === 0"><td colspan="6" class="px-5 py-16 text-center text-slate-500">Новости ещё не созданы.</td></tr>
                    </tbody>
                </table>
            </div>
            <PaginationList :pagination="pagination" />
        </section>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать новость' : 'Создать новость'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input id="name" v-model="form.name" label="Название новости" :error="form.errors.name" required @update:modelValue="validateField && validateField('name', form.name)" />
            <Input id="alias" v-model="form.alias" label="Алиас" :error="form.errors.alias" required @update:modelValue="validateField && validateField('alias', form.alias)" />
            <Input id="sort" v-model.number="form.sort" label="Сортировка" type="number" :error="form.errors.sort" @update:modelValue="validateField && validateField('sort', form.sort)" />
            <Input id="description" v-model="form.description" label="Описание" :error="form.errors.description" multiline />
            <Checkbox id="active" v-model="form.active" text="Активность" :error="form.errors.active" />
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
import Link from '@/components/Link.vue';
import PaginationList from '@/components/PaginationList.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminNews from '@/routes/admin/news';
import type { News } from '@/types/news.ts';
import type { Page } from '@/types/pagination.ts';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ newsPage: Page<News> }>();
const pagination = computed(() =>
    getPaginationFromPageResponse(props.newsPage),
);

type NewsForm = {
    name: string;
    alias: string;
    sort: number;
    description: string;
    active: boolean;
};
const createData = (): NewsForm => ({
    name: '',
    alias: '',
    sort: 500,
    description: '',
    active: false,
});
const newsValidator = (field: keyof NewsForm, value: any) => {
    switch (field) {
        case 'name':
            return validate(value, 'required', 'Название новости обязательно');
        case 'alias':
            return validate(value, 'required', 'Алиас обязателен');
        case 'sort':
            return validate(
                value,
                'required|positiveInteger',
                'Введите корректную сортировку',
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
} = useAdminCrudForm<NewsForm, News>({
    createData,
    editData: ({ alias, sort, name, active, description }) => ({
        alias,
        sort,
        name,
        active,
        description: description ?? '',
    }),
    routes: {
        store: () => AdminNews.store.url(),
        update: (id) => AdminNews.update.url(id),
        destroy: (id) => AdminNews.destroy.url(id),
    },
    validator: newsValidator,
});
const validateField = formValidator?.validateField;
</script>

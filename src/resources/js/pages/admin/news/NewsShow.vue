<template>
    <div class="space-y-6">
        <AdminPageHeader :title="news.name" eyebrow="Новость" description="Просмотр публикации и её основных настроек." :back-url="AdminNews.list.url()">
            <template #actions><Button text="Редактировать" secondary class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm" @click="openEditModal(news)" /></template>
        </AdminPageHeader>
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <dl class="grid gap-5 border-b border-slate-100 pb-6 text-sm sm:grid-cols-4">
                <div><dt class="text-slate-400">ID</dt><dd class="mt-1 font-mono text-xs text-slate-700">#{{ news.id }}</dd></div>
                <div><dt class="text-slate-400">Алиас</dt><dd class="mt-1 font-medium text-slate-800">{{ news.alias }}</dd></div>
                <div><dt class="text-slate-400">Сортировка</dt><dd class="mt-1 font-medium text-slate-800">{{ news.sort }}</dd></div>
                <div><dt class="mb-1 text-slate-400">Активность</dt><dd><Badge :label="news.active ? 'Активна' : 'Скрыта'" :tone="news.active ? 'success' : 'neutral'" /></dd></div>
            </dl>
            <div class="pt-6"><h2 class="text-sm font-semibold text-slate-900">Описание</h2><p v-if="news.description" class="mt-3 max-w-4xl leading-7 whitespace-pre-wrap text-slate-600">{{ news.description }}</p><p v-else class="mt-3 text-slate-400">Описание отсутствует.</p></div>
        </section>
    </div>
    <Popup v-model:open="isFormPopupOpen" title="Редактировать новость">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input
                id="name"
                v-model="form.name"
                label="Название"
                :error="form.errors.name"
                @update:modelValue="
                    validateField && validateField('name', form.name)
                "
            />
            <Input
                id="alias"
                v-model="form.alias"
                label="Алиас"
                :error="form.errors.alias"
                @update:modelValue="
                    validateField && validateField('alias', form.alias)
                "
            />
            <Input
                id="sort"
                v-model.number="form.sort"
                label="Сортировка"
                type="number"
                :error="form.errors.sort"
                @update:modelValue="
                    validateField && validateField('sort', form.sort)
                "
            />
            <Input
                id="description"
                v-model="form.description"
                label="Описание"
                multiline
                :error="form.errors.description"
            />
            <Checkbox
                id="active"
                v-model="form.active"
                text="Активность"
                :error="form.errors.active"
            />
            <Button
                type="submit"
                secondary
                :disabled="form.processing"
                text="Сохранить"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminNews from '@/routes/admin/news';
import type { News } from '@/types/news.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ news: News }>();

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
const { form, formValidator, isFormPopupOpen, openEditModal, submit } =
    useAdminCrudForm<NewsForm, News>({
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

<template>
    <div class="flex flex-col gap-5">
        <div class="w-fit">
            <Link :href="AdminNews.list.url()" text="Назад" secondary />
        </div>
        <div class="flex flex-row gap-10">
            <h1 class="text-4xl text-text-title">{{ news.name }}</h1>
            <div class="w-fit">
                <Button
                    text="Редактировать"
                    class="bg-yellow-400 hover:bg-yellow-500"
                    @click="openEditModal(news)"
                />
            </div>
        </div>
        <div class="flex flex-col gap-2 text-sm text-gray-600">
            <span
                >Id: <b class="text-gray-900">#{{ news.id }}</b></span
            >
            <span>
                Алиас: <b class="text-gray-900">{{ news.alias }}</b>
            </span>
            <span>
                Сортировка: <b class="text-gray-900">{{ news.sort }}</b>
            </span>
            <span>
                Активность:
                <b class="text-gray-900">{{ news.active ? 'Да' : 'Нет' }}</b>
            </span>
        </div>
        <p v-if="news.description" class="max-w-4xl text-gray-700">
            {{ news.description }}
        </p>
        <p v-else class="text-gray-500">Описание отсутствует.</p>
    </div>
    <Popup v-model:open="isFormPopupOpen" title="Редактировать новость">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input
                id="name"
                v-model="form.name"
                placeholder="Название новости"
                label="Название"
                :error="form.errors.name"
                @update:modelValue="validateField('name', form.name)"
            />
            <Input
                id="alias"
                v-model="form.alias"
                placeholder="news-1"
                label="Алиас"
                :error="form.errors.alias"
                @update:modelValue="validateField('alias', form.alias)"
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
            <Textarea
                id="description"
                v-model="form.description"
                placeholder="Текст новости"
                label="Описание"
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
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import Popup from '@/components/Popup.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminNews from '@/routes/admin/news';
import type { News } from '@/types/news';
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
const { form, validateField, isFormPopupOpen, openEditModal, submit } =
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
</script>

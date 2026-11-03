<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Новости</h1>
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
                v-for="newsItem in newsPage.items"
                :key="newsItem.id"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">
                    #{{ newsItem.id }}
                </div>
                <div class="truncate p-4">{{ newsItem.alias }}</div>
                <div class="truncate p-4">{{ newsItem.name }}</div>
                <div class="p-4 whitespace-nowrap">{{ newsItem.sort }}</div>
                <div class="p-4">{{ newsItem.active }}</div>
                <div class="flex flex-wrap gap-2 p-4">
                    <Link
                        style-type="button"
                        :href="AdminNews.show.url(newsItem.id)"
                        text="Просмотр"
                        class="bg-blue-400 hover:bg-blue-500"
                    />
                    <Button
                        text="Редактировать"
                        class="bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(newsItem)"
                    />
                    <Button
                        text="Удалить"
                        class="bg-red-400 hover:bg-red-500"
                        @click="destroy(newsItem.id)"
                    />
                </div>
            </div>
        </div>
    </div>
    <PaginationList v-if="pagination.totalPages > 1" :pagination="pagination" />
    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать новость' : 'Создать новость'"
    >
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
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import PaginationList from '@/components/PaginationList.vue';
import Popup from '@/components/Popup.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminNews from '@/routes/admin/news';
import type { News } from '@/types/news';
import type { Pagination } from '@/types/page-response';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ newsPage: Pagination<News> }>();
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
    validateField,
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
</script>

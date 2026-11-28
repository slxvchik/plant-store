<template>
    <div class="news">
        <AdminPageHeader
            description="Публикации, порядок сортировки и видимость на сайте."
            eyebrow="Контент"
            title="Новости"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Добавить новость"
                    @click="openCreateModal"
                />
            </template>
        </AdminPageHeader>
        <Table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Алиас</th>
                    <th>Название</th>
                    <th>Сортировка</th>
                    <th>Активность</th>
                    <th class="news__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="newsItem in newsPage.items" :key="newsItem.id">
                    <td class="news__id">#{{ newsItem.id.slice(0, 8) }}</td>
                    <td class="news__alias">{{ newsItem.alias }}</td>
                    <td class="news__name">{{ newsItem.name }}</td>
                    <td class="news__sort">{{ newsItem.sort }}</td>
                    <td>
                        <Badge
                            :label="newsItem.active ? 'Активна' : 'Скрыта'"
                            :tone="newsItem.active ? 'success' : 'neutral'"
                        />
                    </td>
                    <td>
                        <div class="news__actions">
                            <Link
                                :href="AdminNews.show.url(newsItem.id)"
                                class="news__open"
                            >
                                Открыть
                            </Link>
                            <Button
                                auto-width
                                ghost
                                small
                                text="Изменить"
                                @click="openEditModal(newsItem)"
                            />
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                @click="destroy(newsItem.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="newsPage.items.length === 0">
                    <td class="news__empty" colspan="6">
                        Новости ещё не созданы.
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="pagination" />
            </template>
        </Table>
        <Modal
            v-model:open="isFormPopupOpen"
            :title="isEditMode ? 'Редактировать новость' : 'Создать новость'"
        >
            <form class="news__form" @submit.prevent="submit">
                <Input
                    id="name"
                    v-model="form.name"
                    :error="form.errors.name"
                    label="Название новости"
                    required
                    @update:modelValue="
                        validateField && validateField('name', form.name)
                    "
                />
                <Input
                    id="alias"
                    v-model="form.alias"
                    :error="form.errors.alias"
                    label="Алиас"
                    required
                    @update:modelValue="
                        validateField && validateField('alias', form.alias)
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
                <Textarea
                    id="description"
                    v-model="form.description"
                    :error="form.errors.description"
                    label="Описание"
                />
                <Checkbox
                    id="active"
                    v-model="form.active"
                    :error="form.errors.active"
                    text="Активность"
                />
                <div class="news__form-footer">
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
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Modal from '@/components/Modal.vue';
import Pagination from '@/components/Pagination.vue';
import Table from '@/components/Table.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
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

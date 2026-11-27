<template>
    <div class="news-show">
        <AdminPageHeader
            :back-url="AdminNews.list.url()"
            :title="news.name"
            description="Просмотр публикации и её основных настроек."
            eyebrow="Новость"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Редактировать"
                    @click="openEditModal(news)"
                />
            </template>
        </AdminPageHeader>
        <Card class="news-show__card">
            <dl class="news-show__details">
                <div>
                    <dt>ID</dt>
                    <dd class="news-show__id">#{{ news.id }}</dd>
                </div>
                <div>
                    <dt>Алиас</dt>
                    <dd>{{ news.alias }}</dd>
                </div>
                <div>
                    <dt>Сортировка</dt>
                    <dd>{{ news.sort }}</dd>
                </div>
                <div>
                    <dt>Активность</dt>
                    <dd>
                        <Badge
                            :label="news.active ? 'Активна' : 'Скрыта'"
                            :tone="news.active ? 'success' : 'neutral'"
                        />
                    </dd>
                </div>
            </dl>
            <div class="news-show__description">
                <h2>Описание</h2>
                <p v-if="news.description">{{ news.description }}</p>
                <p v-else class="news-show__empty">Описание отсутствует.</p>
            </div>
        </Card>
        <Modal v-model:open="isFormPopupOpen" title="Редактировать новость">
            <form class="news-show__form" @submit.prevent="submit">
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
                    id="alias"
                    v-model="form.alias"
                    :error="form.errors.alias"
                    label="Алиас"
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
                <div class="news-show__form-footer">
                    <Button
                        :disabled="form.processing"
                        auto-width
                        secondary
                        text="Сохранить"
                        type="submit"
                    />
                </div>
            </form>
        </Modal>
    </div>
</template>
<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Modal from '@/components/Modal.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
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

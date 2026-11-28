<template>
    <div class="tags">
        <AdminPageHeader
            description="Управляйте метками для быстрого поиска и группировки товаров."
            eyebrow="Каталог"
            title="Теги"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Добавить тег"
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
                    <th class="tags__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tag in tagsPage.items" :key="tag.id">
                    <td class="tags__id">#{{ tag.id.slice(0, 8) }}</td>
                    <td class="tags__alias">{{ tag.alias }}</td>
                    <td class="tags__name">{{ tag.name }}</td>
                    <td class="tags__muted">{{ tag.sort }}</td>
                    <td>
                        <Badge
                            :label="tag.active ? 'Активен' : 'Скрыт'"
                            :tone="tag.active ? 'success' : 'neutral'"
                        />
                    </td>
                    <td>
                        <div class="tags__actions">
                            <Button
                                auto-width
                                outline
                                small
                                text="Изменить"
                                type="button"
                                @click="openEditModal(tag)"
                            />
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                type="button"
                                @click="destroy(tag.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="tagsPage.items.length === 0">
                    <td class="tags__empty" colspan="6">
                        Теги ещё не созданы.
                    </td>
                </tr>
            </tbody>
        </Table>
        <Modal
            v-model:open="isFormPopupOpen"
            :title="isEditMode ? 'Редактировать тег' : 'Создать тег'"
        >
            <form class="tags__form" @submit.prevent="submit">
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
                <div class="tags__form-footer">
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
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Modal from '@/components/Modal.vue';
import Table from '@/components/Table.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
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

<template>
    <div class="users">
        <AdminPageHeader
            description="Учётные записи, контактные данные и роли доступа."
            eyebrow="Администрирование"
            title="Пользователи"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Добавить пользователя"
                    @click="openCreateModal"
                />
            </template>
        </AdminPageHeader>
        <Table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Роли</th>
                    <th class="users__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in usersPage.items" :key="user.id">
                    <td class="users__id">#{{ user.id.slice(0, 8) }}</td>
                    <td class="users__name">
                        {{ user.firstName }} {{ user.lastName ?? '' }}
                    </td>
                    <td class="users__contact">{{ user.email }}</td>
                    <td class="users__phone">{{ user.phone }}</td>
                    <td>
                        <div class="users__roles">
                            <Badge
                                v-for="role in user.roles"
                                :key="role"
                                :label="role"
                                tone="info"
                            />
                        </div>
                    </td>
                    <td>
                        <div class="users__actions">
                            <Link
                                :href="AdminUsers.show.url(user.id)"
                                class="users__open"
                            >
                                Открыть
                            </Link>
                            <Button
                                auto-width
                                ghost
                                small
                                text="Изменить"
                                @click="openEditModal(user)"
                            />
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                @click="destroy(user.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="usersPage.items.length === 0">
                    <td class="users__empty" colspan="6">
                        Пользователи не найдены.
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="pagination" />
            </template>
        </Table>
        <Modal
            v-model:open="isFormPopupOpen"
            :title="
                isEditMode
                    ? 'Редактировать пользователя'
                    : 'Создать пользователя'
            "
        >
            <form class="users__form" @submit.prevent="submit">
                <UserFormFields
                    v-model="form"
                    :errors="form.errors"
                    :is-edit-mode="isEditMode"
                />
                <div class="users__form-footer">
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
import Modal from '@/components/Modal.vue';
import Pagination from '@/components/Pagination.vue';
import Table from '@/components/Table.vue';
import UserFormFields from '@/components/user/UserFormFields.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminUsers from '@/routes/admin/users';
import type { Page } from '@/types/pagination.ts';
import type { User, UserFormState } from '@/types/user.ts';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ usersPage: Page<User> }>();
const pagination = computed(() =>
    getPaginationFromPageResponse(props.usersPage),
);
const createData = (): UserFormState => ({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    password: '',
    emailConfirmed: false,
    roles: ['USER'],
});
const userValidator = (field: keyof UserFormState, value: any) => {
    switch (field) {
        case 'firstName':
            return validate(value, 'required', 'Имя обязательно');
        case 'email':
            return validate(
                value,
                'required|email',
                'Введите корректный email',
            );
        case 'phone':
            return validate(
                value,
                'required|phone',
                'Введите корректный телефон',
            );
        default:
            return null;
    }
};
const {
    form,
    isFormPopupOpen,
    isEditMode,
    openCreateModal,
    openEditModal,
    submit,
    destroy,
} = useAdminCrudForm<UserFormState, User>({
    createData,
    editData: ({
        firstName,
        lastName,
        email,
        phone,
        emailConfirmed,
        roles,
    }) => ({
        firstName,
        lastName: lastName ?? '',
        email,
        phone,
        password: '',
        emailConfirmed,
        roles,
    }),
    routes: {
        store: () => AdminUsers.store.url(),
        update: (id) => AdminUsers.update.url(id),
        destroy: (id) => AdminUsers.destroy.url(id),
    },
    validator: userValidator,
});
</script>

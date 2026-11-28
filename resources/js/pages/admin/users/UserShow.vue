<template>
    <div class="user-show">
        <AdminPageHeader
            :back-url="AdminUsers.list.url()"
            :title="`${user.firstName} ${user.lastName ?? ''}`"
            description="Контактные данные, роли и состояние учётной записи."
            eyebrow="Пользователь"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Редактировать"
                    @click="openEditModal(user)"
                />
            </template>
        </AdminPageHeader>
        <Card class="user-show__card">
            <dl class="user-show__details">
                <div>
                    <dt>ID</dt>
                    <dd class="user-show__id">#{{ user.id }}</dd>
                </div>
                <div>
                    <dt>Email</dt>
                    <dd>{{ user.email }}</dd>
                </div>
                <div>
                    <dt>Телефон</dt>
                    <dd>{{ user.phone }}</dd>
                </div>
                <div>
                    <dt>Роли</dt>
                    <dd class="user-show__roles">
                        <Badge
                            v-for="role in user.roles"
                            :key="role"
                            :label="role"
                            tone="info"
                        />
                    </dd>
                </div>
                <div>
                    <dt>Email подтверждён</dt>
                    <dd>
                        <Badge
                            :label="user.emailConfirmed ? 'Да' : 'Нет'"
                            :tone="user.emailConfirmed ? 'success' : 'neutral'"
                        />
                    </dd>
                </div>
                <div>
                    <dt>Создан</dt>
                    <dd class="user-show__date">{{ user.createdAt }}</dd>
                </div>
                <div>
                    <dt>Обновлён</dt>
                    <dd class="user-show__date">{{ user.updatedAt }}</dd>
                </div>
            </dl>
        </Card>
        <Modal
            v-model:open="isFormPopupOpen"
            title="Редактировать пользователя"
        >
            <form class="user-show__form" @submit.prevent="submit">
                <UserFormFields
                    v-model="form"
                    :errors="form.errors"
                    is-edit-mode
                />
                <div class="user-show__form-footer">
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
import Modal from '@/components/Modal.vue';
import UserFormFields from '@/components/user/UserFormFields.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminUsers from '@/routes/admin/users';
import type { User, UserFormState } from '@/types/user.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ user: User }>();
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
const { form, isFormPopupOpen, openEditModal, submit } = useAdminCrudForm<
    UserFormState,
    User
>({
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

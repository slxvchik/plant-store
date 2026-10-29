<template>
    <div class="flex flex-col gap-5">
        <div class="w-fit">
            <Link :href="AdminUsers.list.url()" text="Назад" secondary />
        </div>
        <div class="flex flex-row gap-10">
            <h1 class="text-4xl text-text-title">
                {{ user.firstName }} {{ user.lastName ?? '' }}
            </h1>
            <div class="w-fit">
                <Button
                    text="Редактировать"
                    class="bg-yellow-400 hover:bg-yellow-500"
                    @click="openEditModal(user)"
                />
            </div>
        </div>
        <div class="flex flex-col gap-2 text-sm text-gray-600">
            <span
                >Id: <b class="text-gray-900">#{{ user.id }}</b></span
            >
            <span>
                Email: <b class="text-gray-900">{{ user.email }}</b>
            </span>
            <span>
                Телефон: <b class="text-gray-900">{{ user.phone }}</b>
            </span>
            <span>
                Роли: <b class="text-gray-900">{{ user.roles.join(', ') }}</b>
            </span>
            <span>
                Email подтверждён:
                <b class="text-gray-900">{{
                    user.emailConfirmed ? 'Да' : 'Нет'
                }}</b>
            </span>
            <span>
                Создан: <b class="text-gray-900">{{ user.createdAt }}</b>
            </span>
            <span>
                Обновлён: <b class="text-gray-900">{{ user.updatedAt }}</b>
            </span>
        </div>
    </div>
    <Popup v-model:open="isFormPopupOpen" title="Редактировать пользователя">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <UserFormFields v-model="form" is-edit-mode :errors="form.errors" />
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
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import UserFormFields from '@/components/UserFormFields.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminUsers from '@/routes/admin/users';
import type { UserFormState } from '@/types/form/user';
import type { User } from '@/types/user';
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

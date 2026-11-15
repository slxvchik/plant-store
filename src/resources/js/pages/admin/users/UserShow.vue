<template>
    <div class="space-y-6">
        <AdminPageHeader :title="`${user.firstName} ${user.lastName ?? ''}`" eyebrow="Пользователь" description="Контактные данные, роли и состояние учётной записи." :back-url="AdminUsers.list.url()">
            <template #actions><Button class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm" secondary text="Редактировать" @click="openEditModal(user)" /></template>
        </AdminPageHeader>
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <dl class="grid gap-x-8 gap-y-6 text-sm sm:grid-cols-2 lg:grid-cols-3">
                <div><dt class="text-slate-400">ID</dt><dd class="mt-1 font-mono text-xs text-slate-700">#{{ user.id }}</dd></div>
                <div><dt class="text-slate-400">Email</dt><dd class="mt-1 font-medium text-slate-800">{{ user.email }}</dd></div>
                <div><dt class="text-slate-400">Телефон</dt><dd class="mt-1 font-medium text-slate-800">{{ user.phone }}</dd></div>
                <div><dt class="text-slate-400">Роли</dt><dd class="mt-1 flex flex-wrap gap-1.5"><Badge v-for="role in user.roles" :key="role" :label="role" tone="info" /></dd></div>
                <div><dt class="mb-1 text-slate-400">Email подтверждён</dt><dd><Badge :label="user.emailConfirmed ? 'Да' : 'Нет'" :tone="user.emailConfirmed ? 'success' : 'neutral'" /></dd></div>
                <div><dt class="text-slate-400">Создан</dt><dd class="mt-1 text-slate-700">{{ user.createdAt }}</dd></div>
                <div><dt class="text-slate-400">Обновлён</dt><dd class="mt-1 text-slate-700">{{ user.updatedAt }}</dd></div>
            </dl>
        </section>
    </div>
    <Popup v-model:open="isFormPopupOpen" title="Редактировать пользователя">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <UserFormFields v-model="form" :errors="form.errors" is-edit-mode />
            <Button
                :disabled="form.processing"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
                secondary
                text="Сохранить"
                type="submit"
            />
        </form>
    </Popup>
</template>

<script lang="ts" setup>
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import UserFormFields from '@/components/user/UserFormFields.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
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

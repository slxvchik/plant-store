<template>
    <div class="space-y-6">
        <AdminPageHeader title="Пользователи" eyebrow="Администрирование" description="Учётные записи, контактные данные и роли доступа.">
            <template #actions><Button secondary text="Добавить пользователя" class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm" @click="openCreateModal" /></template>
        </AdminPageHeader>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto"><table class="w-full min-w-[950px] text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"><tr><th class="px-5 py-4">ID</th><th class="px-5 py-4">Имя</th><th class="px-5 py-4">Email</th><th class="px-5 py-4">Телефон</th><th class="px-5 py-4">Роли</th><th class="px-5 py-4 text-right">Действия</th></tr></thead>
                <tbody class="divide-y divide-slate-100"><tr v-for="user in usersPage.items" :key="user.id" class="hover:bg-slate-50">
                    <td class="px-5 py-4 font-mono text-xs text-slate-400">#{{ user.id.slice(0, 8) }}</td><td class="px-5 py-4 font-semibold text-slate-900">{{ user.firstName }} {{ user.lastName ?? '' }}</td><td class="px-5 py-4 text-slate-600">{{ user.email }}</td><td class="px-5 py-4 whitespace-nowrap text-slate-600">{{ user.phone }}</td><td class="px-5 py-4"><div class="flex flex-wrap gap-1.5"><Badge v-for="role in user.roles" :key="role" :label="role" tone="info" /></div></td>
                    <td class="px-5 py-4"><div class="flex justify-end gap-2"><Link :href="AdminUsers.show.url(user.id)" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700" text="Открыть" /><Button class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-slate-600 hover:!bg-slate-100" text="Изменить" @click="openEditModal(user)" /><Button class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-rose-600 hover:!bg-rose-50" text="Удалить" @click="destroy(user.id)" /></div></td>
                </tr><tr v-if="usersPage.items.length === 0"><td colspan="6" class="px-5 py-16 text-center text-slate-500">Пользователи не найдены.</td></tr></tbody>
            </table></div>
            <PaginationList :pagination="pagination" />
        </section>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать пользователя' : 'Создать пользователя'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <UserFormFields v-model="form" :errors="form.errors" :is-edit-mode="isEditMode" />
            <div class="flex justify-end border-t border-slate-100 pt-5"><Button :disabled="form.processing" :text="isEditMode ? 'Сохранить' : 'Создать'" class="!w-auto !rounded-xl !px-5 !text-sm" secondary type="submit" /></div>
        </form>
    </Popup>
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import PaginationList from '@/components/PaginationList.vue';
import Popup from '@/components/Popup.vue';
import UserFormFields from '@/components/user/UserFormFields.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm.ts';
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

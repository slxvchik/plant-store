<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Пользователи</h1>
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
            <div class="p-4">Имя</div>
            <div class="p-4">Email</div>
            <div class="p-4">Телефон</div>
            <div class="p-4">Роли</div>
            <div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="user in usersPage.items"
                :key="user.id"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">#{{ user.id }}</div>
                <div class="truncate p-4">
                    {{ user.firstName }} {{ user.lastName ?? '' }}
                </div>
                <div class="truncate p-4">{{ user.email }}</div>
                <div class="p-4 whitespace-nowrap">{{ user.phone }}</div>
                <div class="truncate p-4">{{ user.roles.join(', ') }}</div>
                <div class="flex flex-wrap gap-2 p-4">
                    <Link
                        style-type="button"
                        :href="AdminUsers.show.url(user.id)"
                        text="Просмотр"
                        class="bg-blue-400 hover:bg-blue-500"
                    />
                    <Button
                        text="Редактировать"
                        class="bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(user)"
                    />
                    <Button
                        text="Удалить"
                        class="bg-red-400 hover:bg-red-500"
                        @click="destroy(user.id)"
                    />
                </div>
            </div>
        </div>
    </div>
    <PaginationList v-if="pagination.totalPages > 1" :pagination="pagination" />
    <Popup
        v-model:open="isFormPopupOpen"
        :title="
            isEditMode ? 'Редактировать пользователя' : 'Создать пользователя'
        "
    >
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <UserFormFields
                v-model="form"
                :is-edit-mode="isEditMode"
                :errors="form.errors"
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
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import UserFormFields from '@/components/UserFormFields.vue';
import PaginationList from '@/components/PaginationList.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminUsers from '@/routes/admin/users';
import type { UserFormState } from '@/types/form/user';
import type { User } from '@/types/user';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse';
import { validate } from '@/utils/validator.ts';
import type { PageResponse } from '@/types/pageResponse';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ usersPage: PageResponse<User> }>();
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

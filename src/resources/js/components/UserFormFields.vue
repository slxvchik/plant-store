<template>
    <div class="flex flex-col gap-5">
        <Input
            id="firstName"
            v-model="form.firstName"
            placeholder="Иван"
            label="Имя"
            :error="errors?.firstName"
        />
        <Input
            id="lastName"
            v-model="form.lastName"
            placeholder="Иванов"
            label="Фамилия"
            :error="errors?.lastName"
        />
        <Input
            id="email"
            v-model="form.email"
            placeholder="user@example.com"
            type="email"
            label="Email"
            :error="errors?.email"
        />
        <Input
            id="phone"
            v-model="form.phone"
            placeholder="+7 999 999 99 99"
            type="tel"
            label="Телефон"
            :error="errors?.phone"
        />
        <Input
            id="password"
            v-model="form.password"
            :placeholder="
                isEditMode
                    ? 'Оставьте пустым, чтобы не менять'
                    : 'Минимум 8 символов'
            "
            type="password"
            label="Пароль"
            :error="errors?.password"
        />
        <Select
            v-model="form.roles"
            :items="roleOptions"
            label="Роли"
            placeholder="Выберите роли"
            multiple
            :error="errors?.roles"
        />
        <Checkbox
            id="emailConfirmed"
            v-model="form.emailConfirmed"
            text="Email подтверждён"
            :error="errors?.emailConfirmed"
        />
    </div>
</template>

<script setup lang="ts">
import Checkbox from '@/components/Checkbox.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import type { SelectItem } from '@/types/select-item.ts';
import type { UserFormState } from '@/types/user.ts';

interface Props {
    isEditMode?: boolean;
    errors?: Record<string, string | undefined>;
}

withDefaults(defineProps<Props>(), { isEditMode: false });
const form = defineModel<UserFormState>({ required: true });

const roleOptions: SelectItem[] = [
    { value: 'USER', label: 'Пользователь' },
    { value: 'ADMIN', label: 'Администратор' },
    { value: 'MANAGER', label: 'Менеджер' },
    { value: 'WAREHOUSE_WORKER', label: 'Работник склада' },
];
</script>

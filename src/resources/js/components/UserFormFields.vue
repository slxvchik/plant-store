<template>
    <div class="flex flex-col gap-5">
        <Input
            id="firstName"
            v-model="form.firstName"
            :error="errors?.firstName"
            label="Имя"
        />
        <Input
            id="lastName"
            v-model="form.lastName"
            :error="errors?.lastName"
            label="Фамилия"
        />
        <Input
            id="email"
            v-model="form.email"
            :error="errors?.email"
            label="Email"
            type="email"
        />
        <Input
            id="phone"
            v-model="form.phone"
            :error="errors?.phone"
            label="Телефон"
            type="tel"
        />
        <Input
            id="password"
            v-model="form.password"
            :error="errors?.password"
            label="Пароль (оставьте пустым, чтобы не менять)"
            type="password"
        />
        <Select
            v-model="form.roles"
            :error="errors?.roles"
            :items="roleOptions"
            label="Роли"
            multiple
        />
        <Checkbox
            id="emailConfirmed"
            v-model="form.emailConfirmed"
            :error="errors?.emailConfirmed"
            text="Email подтверждён"
        />
    </div>
</template>

<script lang="ts" setup>
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

<template>
    <div class="login">
        <Container>
            <form name="login" id="login-form" class="login__form" @submit.prevent="loginFormSubmit">
                <Input
                  id="login-form-login"
                  type="text"
                  label="Логин"
                  v-model="form.login"
                  required
                />
                <Input
                  id="login-form-password"
                  type="password"
                  label="Пароль"
                  v-model="form.password"
                  required
                />
                <Button
                    :disabled="form.processing"
                    text="Войти"
                    class="login__form-btn"
                    type="submit"
                />
            </form>
        </Container>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Button from '@/components/Button.vue';
import Container from '@/components/Container.vue';
import Input from '@/components/Input.vue';
import { useFormValidator } from '@/composables/useFormValidator.ts';
import AppLayout from '@/layouts/AppLayout.vue';
import LoginRouter from '@/routes/login';
import { useNotificationStore } from '@/stores/useNotificationStore.ts';
import type { LoginFormState } from '@/types/auth.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({
    layout: AppLayout,
});

const notificationStore = useNotificationStore();
const form = useForm<LoginFormState>({
    login: "",
    password: "",
});
const fieldValidator = (field: keyof LoginFormState, value: any) => {
    switch (field) {
        case "login":
            return validate(value, "required", "Логин обязателен");
        case "password":
            return validate(value, "required", "Пароль обязателен");
        default:
            return null;
    }
}
const { validateForm } = useFormValidator<LoginFormState>(
    fieldValidator,
    form,
);
const loginFormSubmit = () => {
    if (!validateForm()) {
        return;
    }

    form.post(LoginRouter.attempt.url(), {
        preserveScroll: true,
        onSuccess: () => {
            form.clearErrors();
        },
        onError: (errors: Record<string, string>) => {
            Object.values(errors).forEach((error) =>
                notificationStore.add(error, 'error', 5000),
            );
        },
    });
}
</script>

<style lang="scss" scoped>
.login {
    display: grid;
    height: 100%;
    min-height: inherit;
    justify-items: center;
    align-items: center;

    &__form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
        border-radius: 28px;
        overflow: hidden;
        background-color: var(--color-bg-elevated);

        &-btn {
            border-radius: 9999px;
        }
    }
}
</style>

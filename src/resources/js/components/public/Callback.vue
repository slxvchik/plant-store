<template>
    <section class="callback">
        <Container>
            <Reveal>
                <div class="callback__card">
                    <div class="callback__visual">
                        <img
                            alt="Цветущая лилия в питомнике"
                            class="callback__image"
                            loading="lazy"
                            src="/images/lily_in_hands.png"
                        />
                        <div class="callback__overlay" />
                        <div class="callback__visual-copy">
                            <p class="callback__visual-title">
                                Спросите садовода
                            </p>
                            <p class="callback__visual-text">
                                Подскажем по наличию сортов, условиям ухода,
                                ценам и доставке.
                            </p>
                        </div>
                    </div>
                    <form
                        class="callback__form"
                        novalidate
                        @submit.prevent="submit"
                    >
                        <p class="callback__eyebrow">
                            Персональная консультация
                        </p>
                        <h2 class="callback__title">Поговорим о вашем саде?</h2>
                        <p class="callback__description">
                            Оставьте контакты — специалист перезвонит в течение
                            двух рабочих часов.
                        </p>
                        <div class="callback__fields">
                            <Input
                                variant="floating"
                                id="callback-fio"
                                v-model="callbackForm.fio"
                                :error="callbackForm.errors.fio"
                                autocomplete="name"
                                label="Ваше имя *"
                                @update:model-value="
                                    formValidator.validateField(
                                        'fio',
                                        callbackForm.fio,
                                    )
                                "
                            />
                            <div class="callback__row">
                                <Input
                                    variant="floating"
                                    id="callback-email"
                                    v-model="callbackForm.email"
                                    :error="callbackForm.errors.email"
                                    autocomplete="email"
                                    label="Почта"
                                    type="email"
                                    @update:model-value="
                                        formValidator.validateField(
                                            'email',
                                            callbackForm.email,
                                        )
                                    "
                                />
                                <Input
                                    variant="floating"
                                    id="callback-phone"
                                    v-model="callbackForm.phone"
                                    :error="callbackForm.errors.phone"
                                    autocomplete="tel"
                                    label="Телефон *"
                                    type="tel"
                                    @update:model-value="
                                        formValidator.validateField(
                                            'phone',
                                            callbackForm.phone,
                                        )
                                    "
                                />
                            </div>
                            <Textarea
                                variant="floating"
                                id="callback-comment"
                                v-model="callbackForm.comment"
                                :error="callbackForm.errors.comment"
                                label="Что вас интересует?"
                            />
                        </div>
                        <Button
                            style-type="link"
                            :disabled="callbackForm.processing"
                            class="callback__submit"
                            type="submit"
                        >
                            {{
                                callbackForm.processing
                                    ? 'Отправляем…'
                                    : 'Запросить консультацию'
                            }}
                            <span
                                v-if="!callbackForm.processing"
                                class="callback__submit-icon"
                            >
                                <Icon name="arrow" />
                            </span>
                        </Button>
                        <Transition name="callback-success">
                            <p
                                v-if="submitted"
                                class="callback__success"
                                role="status"
                            >
                                <span class="callback__success-icon">
                                    <Icon name="check" />
                                </span>
                                Спасибо! Скоро свяжемся с вами.
                            </p>
                        </Transition>
                    </form>
                </div>
            </Reveal>
        </Container>
    </section>
</template>
<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import Input from '@/components/Input.vue';
import Reveal from '@/components/Reveal.vue';
import Textarea from '@/components/Textarea.vue';
import { useFormValidator } from '@/composables/useFormValidator.ts';
import type { UserRequest } from '@/types/user-request.ts';
import { validate } from '@/utils/validator.ts';

type CallbackForm = Omit<UserRequest, 'id'>;
const callbackForm = useForm<CallbackForm>();
const submitted = ref(false);
const validator = (field: keyof CallbackForm, value: any): string | null => {
    switch (field) {
        case 'phone':
            return validate(value, 'required|phone');
        case 'email':
            return validate(value, 'email');
        case 'fio':
            return validate(value, 'required');
        default:
            return null;
    }
};
const formValidator = useFormValidator(validator, callbackForm);
const submit = (): void => {
    submitted.value = false;

    if (!formValidator.validateForm()) {
        return;
    }

    callbackForm.post('/callback', {
        preserveScroll: true,
        onSuccess: () => {
            callbackForm.reset();
            submitted.value = true;
        },
    });
};
</script>
<style lang="scss" scoped>
.callback-success-enter-active {
    @apply transition-all duration-300;
}
.callback-success-enter-from {
    @apply translate-y-2 opacity-0;
}
.callback-success-leave-to {
    @apply opacity-0;
}
</style>

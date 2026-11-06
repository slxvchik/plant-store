<template>
    <section class="bg-bg-base px-4 py-16 md:px-8 md:py-24 dark:bg-bg-night">
        <Reveal>
            <div
                class="mx-auto grid max-w-[1280px] overflow-hidden rounded-[28px] bg-bg-surface lg:grid-cols-2 dark:bg-bg-night-soft"
            >
                <div class="relative min-h-72 overflow-hidden lg:min-h-[560px]">
                    <img
                        src="/images/lily_in_hands.png"
                        alt="Цветущая лилия в питомнике"
                        loading="lazy"
                        class="absolute inset-0 h-full w-full object-cover"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-bg-dark/55 to-transparent"
                    />
                    <div
                        class="absolute right-6 bottom-6 left-6 text-white md:right-8 md:bottom-8 md:left-8"
                    >
                        <p class="font-serif text-2xl">Спросите садовода</p>
                        <p
                            class="mt-2 max-w-sm text-sm leading-6 text-white/65"
                        >
                            Подскажем по наличию сортов, условиям ухода, ценам и
                            доставке.
                        </p>
                    </div>
                </div>
                <form
                    class="p-6 md:p-10 lg:p-12"
                    novalidate
                    @submit.prevent="submit"
                >
                    <p
                        class="text-xs font-semibold tracking-[0.2em] text-primary uppercase dark:text-secondary"
                    >
                        Персональная консультация
                    </p>
                    <h2
                        class="mt-3 font-serif text-3xl text-text-title md:text-4xl dark:text-linen"
                    >
                        Поговорим о вашем саде?
                    </h2>
                    <p
                        class="mt-3 text-sm leading-6 text-text-muted dark:text-white/45"
                    >
                        Оставьте контакты — специалист перезвонит в течение двух
                        рабочих часов.
                    </p>
                    <div class="mt-7 space-y-4">
                        <Input
                            id="callback-fio"
                            v-model="callbackForm.fio"
                            label="Ваше имя *"
                            autocomplete="name"
                            :error="callbackForm.errors.fio"
                            @update:model-value="
                                formValidator.validateField(
                                    'fio',
                                    callbackForm.fio,
                                )
                            "
                        />
                        <div class="grid gap-4 md:grid-cols-2">
                            <Input
                                id="callback-email"
                                v-model="callbackForm.email"
                                type="email"
                                label="Почта"
                                autocomplete="email"
                                :error="callbackForm.errors.email"
                                @update:model-value="
                                    formValidator.validateField(
                                        'email',
                                        callbackForm.email,
                                    )
                                "
                            />
                            <Input
                                id="callback-phone"
                                v-model="callbackForm.phone"
                                type="tel"
                                label="Телефон *"
                                autocomplete="tel"
                                :error="callbackForm.errors.phone"
                                @update:model-value="
                                    formValidator.validateField(
                                        'phone',
                                        callbackForm.phone,
                                    )
                                "
                            />
                        </div>
                        <Input
                            id="callback-comment"
                            v-model="callbackForm.comment"
                            label="Что вас интересует?"
                            multiline
                            :error="callbackForm.errors.comment"
                        />
                    </div>
                    <button
                        type="submit"
                        class="mt-6 flex min-h-13 w-full cursor-pointer items-center justify-center gap-2 rounded-full bg-primary px-6 font-semibold text-white shadow-lg shadow-primary/10 transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary-hover disabled:opacity-60"
                        :disabled="callbackForm.processing"
                    >
                        {{
                            callbackForm.processing
                                ? 'Отправляем…'
                                : 'Запросить консультацию'
                        }}
                        <span v-if="!callbackForm.processing" class="h-4 w-4">
                            <AppIcon name="arrow" />
                        </span>
                    </button>
                    <Transition
                        enter-active-class="transition-all duration-300"
                        enter-from-class="translate-y-2 opacity-0"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="submitted"
                            class="mt-4 flex items-center gap-2 text-sm text-primary dark:text-secondary"
                            role="status"
                        >
                            <span class="h-4 w-4">
                                <AppIcon name="check" />
                            </span>
                            Спасибо! Скоро свяжемся с вами.
                        </p>
                    </Transition>
                </form>
            </div>
        </Reveal>
    </section>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import Input from '@/components/Input.vue';
import Reveal from '@/components/Reveal.vue';
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

    console.log('error');
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

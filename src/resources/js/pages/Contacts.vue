<template>
    <div class="bg-bg-base dark:bg-bg-night">
        <section class="px-4 py-10 md:px-8 md:py-16">
            <div class="mx-auto max-w-[1280px]">
                <nav
                    class="flex items-center gap-2 text-xs text-text-muted dark:text-white/40"
                    aria-label="Хлебные крошки"
                >
                    <Link href="/" class="transition-colors hover:text-primary">
                        Главная
                    </Link>
                    <span>/</span>
                    <span class="text-text-title dark:text-white/65">
                        Контакты
                    </span>
                </nav>
                <Reveal>
                    <div class="mt-7 max-w-3xl">
                        <p
                            class="text-xs font-semibold tracking-[0.2em] text-accent uppercase"
                        >
                            Всегда рады помочь
                        </p>
                        <h1
                            class="mt-3 font-serif text-4xl leading-tight text-text-title md:text-5xl lg:text-6xl dark:text-linen"
                        >
                            Давайте вырастим
                            <br />
                            <em class="text-primary dark:text-secondary">
                                что-то прекрасное
                            </em>
                        </h1>
                        <p
                            class="mt-5 max-w-xl text-sm leading-7 text-text-muted md:text-base dark:text-white/50"
                        >
                            Подберём растение, ответим о доставке или поможем
                            разобраться в уходе. Напишите нам — отвечает живой
                            человек, а не бот.
                        </p>
                    </div>
                </Reveal>

                <div
                    class="mt-10 grid gap-6 md:mt-14 lg:grid-cols-[0.9fr_1.1fr] lg:gap-10"
                >
                    <Reveal direction="right">
                        <div
                            class="flex h-full flex-col overflow-hidden rounded-[28px] bg-bg-surface dark:bg-bg-night-soft"
                        >
                            <div
                                class="relative h-64 overflow-hidden md:h-80 lg:h-auto lg:min-h-72 lg:flex-1"
                            >
                                <img
                                    src="/images/slide_2.avif"
                                    alt="Оранжерея питомника Деулино Сад"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-bg-dark/65 to-transparent"
                                />
                                <div
                                    class="absolute right-5 bottom-5 left-5 text-white"
                                >
                                    <p class="font-serif text-2xl">
                                        Приезжайте в гости
                                    </p>
                                    <p class="mt-1 text-sm text-white/65">
                                        Оранжерея открыта для посещения по
                                        записи
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-5 p-6 md:p-8">
                                <a
                                    href="tel:+74951284567"
                                    class="group flex min-h-12 items-center gap-4"
                                >
                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-bg-elevated text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-white dark:bg-white/5 dark:text-secondary"
                                    >
                                        <span class="h-5 w-5">
                                            <AppIcon name="phone" />
                                        </span>
                                    </span>
                                    <span>
                                        <span
                                            class="block text-xs text-text-muted dark:text-white/40"
                                        >
                                            Позвонить
                                        </span>
                                        <span
                                            class="font-semibold text-text-title dark:text-linen"
                                        >
                                            +7 (495) 128-45-67
                                        </span>
                                    </span>
                                </a>
                                <a
                                    href="mailto:hello@deulino.garden"
                                    class="group flex min-h-12 items-center gap-4"
                                >
                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-bg-elevated text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-white dark:bg-white/5 dark:text-secondary"
                                    >
                                        <span class="h-5 w-5">
                                            <AppIcon name="mail" />
                                        </span>
                                    </span>
                                    <span>
                                        <span
                                            class="block text-xs text-text-muted dark:text-white/40"
                                        >
                                            Написать
                                        </span>
                                        <span
                                            class="font-semibold break-all text-text-title dark:text-linen"
                                        >
                                            hello@deulino.garden
                                        </span>
                                    </span>
                                </a>
                                <div class="flex gap-4">
                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-bg-elevated text-primary dark:bg-white/5 dark:text-secondary"
                                    >
                                        <span class="h-5 w-5">
                                            <AppIcon name="pin" />
                                        </span>
                                    </span>
                                    <div>
                                        <p
                                            class="text-xs text-text-muted dark:text-white/40"
                                        >
                                            Питомник
                                        </p>
                                        <p
                                            class="mt-1 text-sm leading-6 font-semibold text-text-title dark:text-linen"
                                        >
                                            Московская область, Рузский район,
                                            <br />
                                            деревня Деулино
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <span
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-bg-elevated text-primary dark:bg-white/5 dark:text-secondary"
                                    >
                                        <span class="h-5 w-5">
                                            <AppIcon name="clock" />
                                        </span>
                                    </span>
                                    <div>
                                        <p
                                            class="text-xs text-text-muted dark:text-white/40"
                                        >
                                            Время работы
                                        </p>
                                        <p
                                            class="mt-1 text-sm font-semibold text-text-title dark:text-linen"
                                        >
                                            Ежедневно, 09:00–20:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Reveal>

                    <Reveal direction="left" :delay="100">
                        <form
                            class="rounded-[28px] border border-text-title/5 bg-bg-elevated p-6 shadow-[0_10px_50px_rgba(32,43,38,0.05)] md:p-8 lg:p-10 dark:border-white/10 dark:bg-bg-night-soft"
                            novalidate
                            @submit.prevent="submitForm"
                        >
                            <p
                                class="text-xs font-semibold tracking-[0.18em] text-primary uppercase dark:text-secondary"
                            >
                                Форма связи
                            </p>
                            <h2
                                class="mt-3 font-serif text-3xl text-text-title dark:text-linen"
                            >
                                Расскажите, чем помочь
                            </h2>
                            <p
                                class="mt-2 text-sm leading-6 text-text-muted dark:text-white/45"
                            >
                                Ответим в течение двух рабочих часов.
                            </p>
                            <div class="mt-7 space-y-4">
                                <Input
                                    id="contact-name"
                                    v-model="form.fio"
                                    label="Ваше имя *"
                                    autocomplete="name"
                                    :error="clientErrors.fio || form.errors.fio"
                                />
                                <div class="grid gap-4 md:grid-cols-2">
                                    <Input
                                        id="contact-phone"
                                        v-model="form.phone"
                                        type="tel"
                                        label="Телефон *"
                                        autocomplete="tel"
                                        :error="
                                            clientErrors.phone ||
                                            form.errors.phone
                                        "
                                    />
                                    <Input
                                        id="contact-email"
                                        v-model="form.email"
                                        type="email"
                                        label="Электронная почта"
                                        autocomplete="email"
                                        :error="
                                            clientErrors.email ||
                                            form.errors.email
                                        "
                                    />
                                </div>
                                <Input
                                    id="contact-message"
                                    v-model="form.comment"
                                    label="Ваш вопрос *"
                                    multiline
                                    :error="
                                        clientErrors.comment ||
                                        form.errors.comment
                                    "
                                />
                            </div>
                            <button
                                type="submit"
                                class="mt-6 flex min-h-13 w-full cursor-pointer items-center justify-center gap-3 rounded-full bg-primary px-6 font-semibold text-white shadow-lg shadow-primary/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary-hover hover:shadow-xl active:scale-[0.98] disabled:cursor-wait disabled:opacity-60"
                                :disabled="form.processing"
                            >
                                <span
                                    v-if="form.processing"
                                    class="h-5 w-5 animate-spin rounded-full border-2 border-white/30 border-t-white"
                                />
                                <span v-else class="h-5 w-5">
                                    <AppIcon name="arrow" />
                                </span>
                                {{
                                    form.processing
                                        ? 'Отправляем…'
                                        : 'Отправить сообщение'
                                }}
                            </button>
                            <p
                                class="mt-4 text-center text-xs leading-5 text-text-muted dark:text-white/35"
                            >
                                Нажимая кнопку, вы соглашаетесь с политикой
                                обработки персональных данных.
                            </p>
                            <Transition
                                enter-active-class="transition-all duration-300"
                                enter-from-class="translate-y-2 opacity-0"
                                enter-to-class="translate-y-0 opacity-100"
                                leave-active-class="transition-all duration-200"
                                leave-to-class="opacity-0"
                            >
                                <div
                                    v-if="submitted"
                                    class="mt-5 flex items-center gap-3 rounded-2xl bg-sage-soft p-4 text-sm text-primary dark:bg-primary/20 dark:text-secondary"
                                    role="status"
                                >
                                    <span class="h-5 w-5 shrink-0">
                                        <AppIcon name="check" />
                                    </span>
                                    Спасибо! Мы получили сообщение и скоро
                                    свяжемся с вами.
                                </div>
                            </Transition>
                        </form>
                    </Reveal>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import Layout from '@/components/layouts/Layout.vue';
import Reveal from '@/components/Reveal.vue';
import Input from '@/components/Input.vue';

defineOptions({ layout: Layout });
const form = useForm({ fio: '', phone: '', email: '', comment: '' });
const clientErrors = reactive<Record<string, string>>({});
const submitted = ref(false);

const validate = (): boolean => {
    Object.keys(clientErrors).forEach((key) => delete clientErrors[key]);

    if (form.fio.trim().length < 2) {
        clientErrors.fio = 'Укажите имя — минимум 2 символа.';
    }

    if (form.phone.replace(/\D/g, '').length < 10) {
        clientErrors.phone = 'Введите телефон с кодом города или оператора.';
    }

    if (form.email && !/^\S+@\S+\.\S+$/.test(form.email)) {
        clientErrors.email = 'Проверьте адрес электронной почты.';
    }

    if (form.comment.trim().length < 10) {
        clientErrors.comment =
            'Опишите вопрос чуть подробнее — минимум 10 символов.';
    }

    return Object.keys(clientErrors).length === 0;
};

const submitForm = (): void => {
    submitted.value = false;

    if (!validate()) {
        return;
    }

    form.post('/callback', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            submitted.value = true;
        },
    });
};
</script>

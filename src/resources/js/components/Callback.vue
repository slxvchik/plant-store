<template>
    <section class="bg-bg-base px-4 py-16 md:px-8 md:py-24 dark:bg-bg-night">
        <Reveal>
            <div
                class="mx-auto grid max-w-[1280px] overflow-hidden rounded-[28px] bg-bg-surface lg:grid-cols-2 dark:bg-bg-night-soft"
            >
                <div class="relative min-h-72 overflow-hidden lg:min-h-[560px]">
                    <img
                        src="/images/water-lily.png"
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
                        <FloatingField
                            id="callback-fio"
                            v-model="form.fio"
                            label="Ваше имя *"
                            autocomplete="name"
                            :error="form.errors.fio"
                        />
                        <div class="grid gap-4 md:grid-cols-2">
                            <FloatingField
                                id="callback-email"
                                v-model="form.email"
                                type="email"
                                label="Почта"
                                autocomplete="email"
                                :error="form.errors.email"
                            /><FloatingField
                                id="callback-phone"
                                v-model="form.phone"
                                type="tel"
                                label="Телефон *"
                                autocomplete="tel"
                                :error="form.errors.phone"
                            />
                        </div>
                        <FloatingField
                            id="callback-comment"
                            v-model="form.comment"
                            label="Что вас интересует?"
                            multiline
                            :error="form.errors.comment"
                        />
                    </div>
                    <button
                        type="submit"
                        class="mt-6 flex min-h-13 w-full cursor-pointer items-center justify-center gap-2 rounded-full bg-primary px-6 font-semibold text-white shadow-lg shadow-primary/10 transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary-hover disabled:opacity-60"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing
                                ? 'Отправляем…'
                                : 'Запросить консультацию'
                        }}<span v-if="!form.processing" class="h-4 w-4"
                            ><AppIcon name="arrow"
                        /></span>
                    </button>
                    <Transition
                        enter-active-class="transition-all duration-300"
                        enter-from-class="translate-y-2 opacity-0"
                        leave-to-class="opacity-0"
                        ><p
                            v-if="submitted"
                            class="mt-4 flex items-center gap-2 text-sm text-primary dark:text-secondary"
                            role="status"
                        >
                            <span class="h-4 w-4"><AppIcon name="check" /></span
                            >Спасибо! Скоро свяжемся с вами.
                        </p></Transition
                    >
                </form>
            </div>
        </Reveal>
    </section>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import FloatingField from '@/components/FloatingField.vue';
import Reveal from '@/components/Reveal.vue';

const form = useForm({ fio: '', phone: '', email: '', comment: '' });
const submitted = ref(false);
const submit = (): void => {
    submitted.value = false;
    form.post('/callback', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            submitted.value = true;
        },
    });
};
</script>

<template>
    <footer
        class="bg-bg-base px-3 pt-8 pb-3 sm:px-8 sm:pt-16 xl:px-20 xl:pt-20"
    >
        <div class="mb-6 flex flex-col justify-between sm:flex-row">
            <div class="mb-4 flex max-w-70 flex-col md:max-w-120">
                <div class="mb-4 flex flex-row gap-2">
                    <div class="h-10 w-10">
                        <LogoIcon />
                    </div>
                    <p
                        class="font-serif text-2xl tracking-tight text-text-title xl:text-3xl"
                    >
                        Деулино Сад
                    </p>
                </div>
                <p class="font-sans text-base text-text-muted xl:text-lg">
                    Выращиваем здоровые саженцы с любовью и заботой. Ваш богатый
                    урожай — наша главная гордость.
                </p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex min-w-30 flex-col gap-3">
                    <p class="text-xl font-semibold text-accent uppercase">
                        Поддержка
                    </p>
                    <div class="flex flex-col gap-2.5">
                        <Button
                            styleType="link"
                            v-for="text in ['Гарантия', 'Возврат', 'Оферта']"
                            :text="text"
                            class="w-fit"
                        />
                    </div>
                </div>
            </div>
        </div>
        <p class="text-xs text-gray-300">Developed by @slxvchik</p>
        <span class="flex h-px w-full bg-gray-300"></span>
        <div class="mt-6 flex flex-col items-center sm:items-start">
            <p
                class="mb-2 text-center text-base text-text-muted sm:text-left xl:text-lg"
            >
                © 2026 Питомник растений "Деулино-Сад"
            </p>
            <ul class="flex flex-col items-center gap-2 sm:flex-row">
                <template
                    v-for="(text, index) in [
                        'Политика обработки персональных данных',
                        'Политика конфиденциальности',
                    ]"
                >
                    <span
                        v-if="index > 0"
                        class="hidden text-gray-400 sm:inline"
                        >·</span
                    >
                    <li>
                        <Button
                            styleType="link"
                            :text="text"
                            class="text-center sm:text-left"
                        />
                    </li>
                </template>
            </ul>
        </div>
    </footer>
</template>

<script setup lang="ts">
import LogoIcon from '@/components/icons/LogoIcon.vue';
import Link from '@/components/Link.vue';
import Button from '@/components/Button.vue';
</script>

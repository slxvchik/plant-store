<template>
    <footer class="px-3 pt-8 pb-3 bg-bg-1 sm:px-8 sm:pt-16 xl:px-20 xl:pt-20">
        <div class="flex flex-col justify-between mb-6 sm:flex-row">
            <div class="flex flex-col mb-4 max-w-70 md:max-w-120">
                <div class="flex flex-row mb-4 gap-2">
                    <LogoIcon class="w-10 h-10" />
                    <p class="font-serif text-2xl tracking-tight text-main xl:text-3xl">
                        Деулино Сад
                    </p>
                </div>
                <p class="font-sans text-muted text-base xl:text-lg">
                    Выращиваем здоровые саженцы с любовью и заботой. Ваш богатый урожай —
                    наша главная гордость.
                </p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-3 min-w-30">
                    <p class="text-xl font-semibold text-accent uppercase">Поддержка</p>
                    <div class="flex flex-col gap-2.5">
                        <Link v-for="text in [
                            'Гарантия',
                            'Возврат',
                            'Оферта'
                        ]" :text="text" class="w-fit" />
                    </div>
                </div>
            </div>
        </div>
        <span class="flex w-full h-px bg-gray-300"></span>
        <div class="flex flex-col items-center mt-6 sm:items-start">
            <p class="mb-2 text-center text-muted text-base sm:text-left xl:text-lg">
                © 2026 Питомник растений "Деулино-Сад"
            </p>
            <ul class="flex flex-col items-center gap-2 sm:flex-row">
                <template v-for="(text, index) in [
                    'Политика обработки персональных данных',
                    'Политика конфиденциальности'
                ]">
                    <span v-if="index > 0" class="hidden sm:inline text-gray-400">·</span>
                    <li>
                        <Link :text="text" class="text-center sm:text-left" />
                    </li>
                </template>
            </ul>
            <p class="text-gray-300 text-xs">Developed by @slxvchik</p>
        </div>
    </footer>
</template>

<script setup lang="ts">
import LogoIcon from '@/components/icons/LogoIcon.vue';
import Link from '@/components/Link.vue';
</script>
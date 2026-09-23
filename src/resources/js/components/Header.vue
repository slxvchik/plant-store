<template>
    <header class="bg-moss-50/90 sticky top-0 z-40"
        :class="isBurgerMenuOpen ? 'bg-white' : 'bg-white/50 backdrop-blur'">
        <div class="mx-auto flex items-center justify-between px-4 py-3">
            <a href="/" class="flex items-center gap-2.5">
                <LogoIcon class="w-10 h-10" />
                <p class="relative bottom-0.5 font-serif text-2xl tracking-tight text-text-title xl:text-3xl">
                    Деулино Сад
                </p>
            </a>
            <!-- Главное меню сайта -->
            <nav class="relative top-0.5 hidden md:flex" aria-label="Главное меню">
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li v-for="link in [
                        { href: '/search', text: 'Поиск' },
                        { href: '/catalog', text: 'Каталог' },
                        { href: '/blog', text: 'Блог' },
                        { href: '/about', text: 'О нас' },
                    ]">
                        <Link :href="link.href" :text="link.text" />
                    </li>
                </ul>
            </nav>
            <!-- Личный кабинет и корзина -->
            <nav class="relative top-0.5 hidden md:flex" aria-label="Пользовательское меню">
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li>
                        <Link href="/basket" class="h-6 w-6">
                            <template #after-text>
                                <BasketIcon />
                            </template>
                        </Link>
                    </li>
                    <li>
                        <Link href="/profile" text="Личный кабинет" />
                    </li>
                </ul>
            </nav>
            <button id="menu-btn" class="relative top-0.5 rounded-lg p-2 md:hidden" aria-label="Открыть меню"
                @click="isBurgerMenuOpen = !isBurgerMenuOpen">
                <BurgerMenu :is-open="isBurgerMenuOpen" />
            </button>
        </div>
        <div v-show="isBurgerMenuOpen" id="mobile-menu"
            class="absolute w-full min-h-screen border-t px-4 py-3 bg-white md:hidden">
            <ul class="text-moss-700 flex flex-col gap-3 text-sm font-medium">
                <li v-for="link in [
                    { href: '/search', text: 'Поиск' },
                    { href: '/catalog', text: 'Каталог' },
                    { href: '/blog', text: 'Блог' },
                    { href: '/about', text: 'О нас' },
                    { href: '/cart', text: 'Корзина' },
                    { href: '/profile', text: 'Личный кабинет' },
                ]">
                    <Link :href="link.href" :text="link.text" />
                </li>
            </ul>
        </div>
    </header>
</template>

<script setup lang="ts">
import LogoIcon from '@/components/icons/LogoIcon.vue';
import BasketIcon from '@/components/icons/BasketIcon.vue';
import BurgerMenu from '@/components/icons/BurgerMenu.vue';
import Link from '@/components/Link.vue';
import { ref } from 'vue';
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';

const isBurgerMenuOpen = ref(false);

useBodyScrollLock(isBurgerMenuOpen);
</script>

<style scoped></style>

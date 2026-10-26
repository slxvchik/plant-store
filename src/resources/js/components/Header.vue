<template>
    <header
        class="bg-moss-50/90 sticky top-0 z-40"
        :class="isBurgerMenuOpen ? 'bg-white' : 'bg-white/50 backdrop-blur'"
    >
        <div class="mx-auto flex items-center justify-between px-4 py-3">
            <a href="/" class="flex items-center gap-2.5">
                <div class="h-10 w-10">
                    <LogoIcon />
                </div>
                <p
                    class="relative bottom-0.5 font-serif text-2xl tracking-tight text-text-title xl:text-3xl"
                >
                    Деулино Сад
                </p>
            </a>
            <!-- Главное меню сайта -->
            <nav
                class="relative top-0.5 hidden md:flex"
                aria-label="Главное меню"
            >
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li>
                        <Link href="/search" text="Поиск" secondary />
                    </li>
                    <li>
                        <Link href="/catalog" text="Каталог" secondary />
                    </li>
                    <li>
                        <Link href="/blog" text="Блог" secondary />
                    </li>
                    <li>
                        <Link href="/about" text="О нас" secondary />
                    </li>
                </ul>
            </nav>
            <!-- Личный кабинет и корзина -->
            <nav
                class="relative top-0.5 hidden md:flex"
                aria-label="Пользовательское меню"
            >
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li>
                        <Link href="/basket" secondary>
                            <template #after-text>
                                <div class="relative h-6 w-6">
                                    <BasketIcon />
                                </div>
                            </template>
                        </Link>
                    </li>
                    <li>
                        <Link href="/profile" text="Личный кабинет" secondary />
                    </li>
                </ul>
            </nav>
            <button
                id="menu-btn"
                class="relative top-0.5 rounded-lg p-2 md:hidden"
                aria-label="Открыть меню"
                @click="isBurgerMenuOpen = !isBurgerMenuOpen"
            >
                <BurgerMenu :is-open="isBurgerMenuOpen" />
            </button>
        </div>
        <div
            v-show="isBurgerMenuOpen"
            id="mobile-menu"
            class="absolute min-h-screen w-full border-t bg-white px-4 py-3 md:hidden"
        >
            <ul class="text-moss-700 flex flex-col gap-3 text-sm font-medium">
                <li
                    v-for="link in [
                        { href: '/search', text: 'Поиск' },
                        { href: '/catalog', text: 'Каталог' },
                        { href: '/blog', text: 'Блог' },
                        { href: '/about', text: 'О нас' },
                        { href: '/cart', text: 'Корзина' },
                        { href: '/profile', text: 'Личный кабинет' },
                    ]"
                    :key="link.href"
                >
                    <Link :href="link.href" :text="link.text" />
                </li>
            </ul>
        </div>
    </header>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import BurgerMenu from '@/components/BurgerMenu.vue';
import BasketIcon from '@/components/icons/BasketIcon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import Link from '@/components/Link.vue';
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';

const isBurgerMenuOpen = ref(false);

useBodyScrollLock(isBurgerMenuOpen);
</script>

<style scoped></style>

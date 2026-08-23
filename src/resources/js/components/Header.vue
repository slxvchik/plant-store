<template>
    <header class="bg-moss-50/90 sticky top-0 z-40 bg-white/50 backdrop-blur">
        <div class="mx-auto flex items-center justify-between px-4 py-3">
            <a href="/" class="flex items-center gap-2.5">
                <LogoIcon class="w-10 h-10" />
                <span
                    class="font-serif text-lg tracking-tight text-main sm:text-xl"
                    >Деулино Сад</span
                >
            </a>
            <!-- Главное меню сайта -->
            <nav class="hidden md:flex" aria-label="Главное меню">
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li>
                        <a
                            class="text-muted transition-colors hover:text-muted-hover"
                            href="/search"
                            >Поиск</a
                        >
                    </li>
                    <li>
                        <a
                            class="text-muted transition-colors hover:text-muted-hover"
                            href="/catalog"
                            >Каталог</a
                        >
                    </li>
                    <li>
                        <a
                            class="text-muted transition-colors hover:text-muted-hover"
                            href="/blog"
                            >Блог</a
                        >
                    </li>
                    <li>
                        <a
                            class="text-muted transition-colors hover:text-muted-hover"
                            href="/about"
                            >О нас</a
                        >
                    </li>
                </ul>
            </nav>
            <!-- Личный кабинет и корзина -->
            <nav class="hidden md:flex" aria-label="Пользовательское меню">
                <ul class="flex items-center gap-6 text-sm font-medium">
                    <li>
                        <a
                            class="h-6 w-6 text-muted transition-colors hover:text-muted-hover"
                            href="/basket"
                        >
                            <BasketIcon />
                        </a>
                    </li>
                    <li>
                        <a
                            class="text-muted transition-colors hover:text-muted-hover"
                            href="/profile"
                            >Личный кабинет</a
                        >
                    </li>
                </ul>
            </nav>
            <button
                id="menu-btn"
                class="rounded-lg p-2 md:hidden"
                aria-label="Открыть меню"
            >
                <BurgerMenu />
            </button>
        </div>
        <div
            id="mobile-menu"
            class="hidden border-t px-4 py-3 md:hidden"
        >
            <ul class="text-moss-700 flex flex-col gap-3 text-sm font-medium">
                <li>
                    <a class="text-muted" href="/search">Поиск</a>
                </li>
                <li>
                    <a class="text-muted" href="/catalog">Каталог</a>
                </li>
                <li>
                    <a class="text-muted" href="/blog">Блог</a>
                </li>
                <li>
                    <a class="text-muted" href="/about">О нас</a>
                </li>
                <li>
                    <a class="text-muted" href="/cart">Корзина</a>
                </li>
                <li>
                    <a class="text-muted" href="/profile">Личный кабинет</a>
                </li>
            </ul>
        </div>
    </header>
</template>

<script setup lang="ts">
import LogoIcon from '@/components/icons/LogoIcon.vue';
import BasketIcon from '@/components/icons/BasketIcon.vue';
import BurgerMenu from '@/components/icons/BurgerMenu.vue';
</script>

<style scoped></style>

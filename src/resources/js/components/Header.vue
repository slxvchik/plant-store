<template>
    <header
        class="sticky top-0 z-40 border-b border-text-title/5 bg-bg-base/90 backdrop-blur-xl transition-colors duration-300 dark:border-white/10 dark:bg-bg-night/90"
    >
        <div
            class="mx-auto flex h-18 w-full max-w-[1440px] items-center justify-between px-4 md:px-8 lg:h-22 xl:px-12"
        >
            <Link
                href="/"
                class="group flex min-h-11 items-center gap-2.5"
                aria-label="Деулино Сад — на главную"
            >
                <span
                    class="h-9 w-9 text-primary transition-transform duration-500 group-hover:rotate-12 lg:h-10 lg:w-10 dark:text-secondary"
                >
                    <LogoIcon />
                </span>
                <span
                    class="font-serif text-[22px] leading-none font-semibold tracking-tight text-text-title lg:text-[26px] dark:text-linen"
                >
                    деулино
                    <span
                        class="font-normal text-primary italic dark:text-secondary"
                        >garden</span
                    >
                </span>
            </Link>

            <nav
                class="hidden items-center gap-1 lg:flex"
                aria-label="Главное меню"
            >
                <div
                    v-for="item in navigation"
                    :key="item.label"
                    class="relative"
                >
                    <Link
                        v-if="!item.children"
                        :href="item.href"
                        class="flex min-h-11 items-center rounded-full px-4 text-[15px] font-medium text-text-muted transition-all duration-300 hover:bg-bg-surface hover:text-text-title dark:text-white/65 dark:hover:bg-white/5 dark:hover:text-white"
                        :class="
                            page.url.startsWith(item.href)
                                ? 'text-primary dark:text-secondary'
                                : ''
                        "
                    >
                        {{ item.label }}
                    </Link>
                    <button
                        v-else
                        type="button"
                        class="flex min-h-11 cursor-pointer items-center gap-1.5 rounded-full px-4 text-[15px] font-medium text-text-muted transition-all duration-300 hover:bg-bg-surface hover:text-text-title dark:text-white/65 dark:hover:bg-white/5 dark:hover:text-white"
                        :aria-expanded="openMenu === item.label"
                        @click="
                            openMenu =
                                openMenu === item.label ? null : item.label
                        "
                    >
                        {{ item.label }}
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            class="h-3.5 w-3.5 transition-transform duration-300"
                            :class="openMenu === item.label ? 'rotate-180' : ''"
                            aria-hidden="true"
                        >
                            <path
                                d="m6 9 6 6 6-6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </button>
                    <Transition
                        enter-active-class="transition-all duration-200 ease-out"
                        enter-from-class="translate-y-2 opacity-0"
                        enter-to-class="translate-y-0 opacity-100"
                        leave-active-class="transition-all duration-150 ease-in"
                        leave-to-class="translate-y-2 opacity-0"
                    >
                        <div
                            v-if="item.children && openMenu === item.label"
                            class="absolute top-full left-0 w-64 rounded-2xl border border-text-title/5 bg-bg-elevated p-2 shadow-[0_20px_60px_rgba(32,43,38,0.14)] dark:border-white/10 dark:bg-bg-night-soft"
                        >
                            <Link
                                v-for="child in item.children"
                                :key="child.label"
                                :href="child.href"
                                class="flex min-h-11 items-center justify-between rounded-xl px-3 py-2 text-sm text-text-muted transition-all duration-300 hover:bg-bg-surface hover:pl-4 hover:text-primary dark:text-white/65 dark:hover:bg-white/5 dark:hover:text-secondary"
                                @click="openMenu = null"
                            >
                                {{ child.label }}
                                <span class="h-4 w-4"
                                    ><AppIcon name="arrow"
                                /></span>
                            </Link>
                        </div>
                    </Transition>
                </div>
            </nav>

            <div class="flex items-center gap-1 md:gap-2">
                <button
                    type="button"
                    class="hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full text-text-muted transition-all duration-300 hover:rotate-6 hover:bg-bg-surface hover:text-primary md:flex dark:text-white/65 dark:hover:bg-white/5"
                    aria-label="Поиск по каталогу"
                    @click="router.visit('/catalog')"
                >
                    <span class="h-5 w-5"><AppIcon name="search" /></span>
                </button>
                <button
                    type="button"
                    class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full text-text-muted transition-all duration-300 hover:rotate-12 hover:bg-bg-surface hover:text-primary dark:text-white/65 dark:hover:bg-white/5"
                    :aria-label="
                        isDark
                            ? 'Включить светлую тему'
                            : 'Включить тёмную тему'
                    "
                    @click="toggleTheme"
                >
                    <span class="h-5 w-5"
                        ><AppIcon :name="isDark ? 'sun' : 'moon'"
                    /></span>
                </button>
                <button
                    type="button"
                    class="relative hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full text-text-muted transition-all duration-300 hover:bg-bg-surface hover:text-primary lg:flex dark:text-white/65 dark:hover:bg-white/5"
                    aria-label="Открыть корзину"
                    @click="isCartOpen = true"
                >
                    <span class="h-5 w-5"><AppIcon name="cart" /></span>
                    <span
                        v-if="itemCount"
                        class="absolute top-0.5 right-0 flex h-5 min-w-5 items-center justify-center rounded-full bg-accent px-1 text-[10px] font-bold text-white"
                    >
                        {{ itemCount }}
                    </span>
                </button>
                <Link
                    href="/contacts"
                    class="ml-2 hidden min-h-11 items-center rounded-full bg-primary px-5 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary-hover hover:shadow-lg xl:flex"
                >
                    Связаться с нами
                </Link>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import { useCartDrawer } from '@/composables/useCartDrawer';
import { useTheme } from '@/composables/useTheme';

const page = usePage();
const openMenu = ref<string | null>(null);
const { isDark, toggleTheme } = useTheme();
const { isCartOpen, itemCount } = useCartDrawer();

const navigation = [
    {
        label: 'Каталог',
        href: '/catalog',
        children: [
            { label: 'Все растения', href: '/catalog' },
            { label: 'Комнатные растения', href: '/catalog' },
            { label: 'Деревья и крупномеры', href: '/catalog' },
            { label: 'Новые поступления', href: '/catalog' },
        ],
    },
    {
        label: 'О питомнике',
        href: '/about',
        children: [
            { label: 'Наша история', href: '/#mission' },
            { label: 'Как мы выращиваем', href: '/#mission' },
            { label: 'Доставка и гарантия', href: '/#delivery' },
        ],
    },
    { label: 'Садовый журнал', href: '/#journal' },
    { label: 'Контакты', href: '/contacts' },
];
</script>

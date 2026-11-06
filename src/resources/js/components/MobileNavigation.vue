<template>
    <nav
        class="fixed inset-x-0 bottom-0 z-40 border-t border-text-title/10 bg-bg-elevated/95 px-3 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] shadow-[0_-8px_30px_rgba(32,43,38,0.08)] backdrop-blur-xl lg:hidden dark:border-white/10 dark:bg-bg-night-soft/95"
        aria-label="Мобильная навигация"
    >
        <div class="mx-auto grid max-w-md grid-cols-4">
            <Link
                v-for="item in items"
                :key="item.label"
                :href="item.href"
                class="flex min-h-12 flex-col items-center justify-center gap-1 rounded-xl text-[11px] font-medium transition-all duration-300 ease-in-out active:scale-95"
                :class="
                    isActive(item.href)
                        ? 'text-primary dark:text-secondary'
                        : 'text-text-muted dark:text-white/50'
                "
            >
                <span
                    class="h-5 w-5 transition-transform duration-300"
                    :class="isActive(item.href) ? '-translate-y-0.5' : ''"
                >
                    <AppIcon :name="item.icon" />
                </span>
                {{ item.label }}
            </Link>
            <button
                type="button"
                class="relative flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-xl text-[11px] font-medium transition-all duration-300 ease-in-out active:scale-95"
                :class="
                    isCartOpen
                        ? 'text-primary dark:text-secondary'
                        : 'text-text-muted dark:text-white/50'
                "
                aria-label="Открыть корзину"
                @click="isCartOpen = true"
            >
                <span class="relative h-5 w-5">
                    <AppIcon name="cart" />
                    <span
                        v-if="itemCount"
                        class="absolute -top-2 -right-3 flex h-4 min-w-4 items-center justify-center rounded-full bg-accent px-1 text-[9px] font-bold text-white"
                        >{{ itemCount }}</span
                    >
                </span>
                Корзина
            </button>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppIcon from '@/components/AppIcon.vue';
import { useCartDrawer } from '@/composables/useCartDrawer';

const page = usePage();
const { isCartOpen, itemCount } = useCartDrawer();
const items = [
    { label: 'Главная', href: '/', icon: 'home' as const },
    { label: 'Каталог', href: '/catalog', icon: 'catalog' as const },
    { label: 'Контакты', href: '/contacts', icon: 'mail' as const },
];

const isActive = (href: string): boolean =>
    href === '/' ? page.url === '/' : page.url.startsWith(href);
</script>

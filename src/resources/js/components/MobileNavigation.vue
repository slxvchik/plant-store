<template>
    <nav
        aria-label="Мобильная навигация"
        class="fixed inset-x-0 bottom-0 z-40 border-t border-text-title/10 bg-bg-elevated/95 px-3 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] shadow-[0_-8px_30px_rgba(32,43,38,0.08)] backdrop-blur-xl lg:hidden dark:border-white/10 dark:bg-bg-night-soft/95"
    >
        <div class="mx-auto grid max-w-md grid-cols-4">
            <Link
                v-for="item in items"
                :key="item.label"
                :class="
                    isActive(item.href)
                        ? 'text-primary dark:text-secondary'
                        : 'text-text-muted dark:text-white/50'
                "
                :href="item.href"
                class="flex min-h-12 flex-col items-center justify-center gap-1 rounded-xl text-[11px] font-medium transition-all duration-300 ease-in-out active:scale-95"
            >
                <span
                    :class="isActive(item.href) ? '-translate-y-0.5' : ''"
                    class="h-5 w-5 transition-transform duration-300"
                >
                    <AppIcon :name="item.icon" />
                </span>
                {{ item.label }}
            </Link>
        </div>
    </nav>
</template>

<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import AppIcon from '@/components/AppIcon.vue';

const page = usePage();
const items = [
    { label: 'Главная', href: '/', icon: 'home' as const },
    { label: 'Каталог', href: '/catalog', icon: 'catalog' as const },
    { label: 'Контакты', href: '/contacts', icon: 'mail' as const },
    { label: 'Корзина', href: '/user/cart', icon: 'cart' as const },
];

const isActive = (href: string): boolean =>
    href === '/' ? page.url === '/' : page.url.startsWith(href);
</script>

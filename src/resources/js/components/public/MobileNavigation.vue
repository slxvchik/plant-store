<template>
    <nav aria-label="Мобильная навигация" class="mobile-navigation">
        <div class="mobile-navigation__items">
            <Link
                v-for="item in items"
                :key="item.label"
                :class="linkClasses(item.href)"
                :href="item.href"
            >
                <span :class="iconClasses(item.href)">
                    <Icon :name="item.icon" />
                </span>
                {{ item.label }}
            </Link>
        </div>
    </nav>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import Icon from '@/components/icons/Icon.vue';
import Link from '@/components/Link.vue';

const page = usePage();
const items = [
    { label: 'Главная', href: '/', icon: 'home' as const },
    { label: 'Каталог', href: '/catalog', icon: 'catalog' as const },
    { label: 'Контакты', href: '/contacts', icon: 'mail' as const },
    { label: 'Корзина', href: '/user/cart', icon: 'cart' as const },
];
const isActive = (href: string) =>
    href === '/' ? page.url === '/' : page.url.startsWith(href);
const linkClasses = (href: string) => [
    'mobile-navigation__link',
    { 'mobile-navigation__link--active': isActive(href) },
];
const iconClasses = (href: string) => [
    'mobile-navigation__icon',
    { 'mobile-navigation__icon--active': isActive(href) },
];
</script>

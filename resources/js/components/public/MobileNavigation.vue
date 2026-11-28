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
            <Button
                v-if="user"
                aria-label="Выйти из аккаунта"
                style-type="link"
                class="mobile-navigation__link"
                @click="logoutUser"
            >
                <span class="mobile-navigation__icon">
                    <Icon name="logout" />
                </span>
                Выйти
            </Button>
        </div>
    </nav>
</template>

<script lang="ts" setup>
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import Link from '@/components/Link.vue';
import { logout as LogoutRoute } from '@/routes';

const page = usePage();
const items = [
    { label: 'Главная', href: '/', icon: 'home' as const },
    { label: 'Каталог', href: '/catalog', icon: 'catalog' as const },
    { label: 'Контакты', href: '/contacts', icon: 'mail' as const },
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
const user = computed(() => page.props.auth.user);
const logoutUser = () => {
    router.post(LogoutRoute.url());
}
</script>

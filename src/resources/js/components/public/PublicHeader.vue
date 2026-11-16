<template>
    <header class="public-header">
        <Container>
            <div class="public-header__inner">
                <Link
                    aria-label="Деулино Сад — на главную"
                    class="public-header__brand"
                    href="/"
                >
                    <span class="public-header__logo"><LogoIcon /></span>
                    <span class="public-header__brand-name">
                        Деулино
                        <span class="public-header__brand-accent">Сад</span>
                    </span>
                </Link>
                <nav aria-label="Главное меню" class="public-header__nav">
                    <div
                        v-for="item in navigation"
                        :key="item.label"
                        class="public-header__nav-item"
                    >
                        <Link
                            v-if="!item.children"
                            :class="navLinkClasses(item.href)"
                            :href="item.href"
                        >
                            {{ item.label }}
                        </Link>
                        <Button
                            v-else
                            :aria-expanded="openMenu === item.label"
                            :text="item.label"
                            class="public-header__nav-button"
                            style-type="link"
                            type="button"
                            @click.stop="
                                openMenu =
                                    openMenu === item.label ? null : item.label
                            "
                        >
                            <span :class="chevronClasses(item.label)">
                                <Icon name="chevron" />
                            </span>
                        </Button>
                        <Transition name="public-header-dropdown">
                            <div
                                v-if="item.children && openMenu === item.label"
                                v-click-outside="closeMenu"
                                class="public-header__dropdown"
                            >
                                <Link
                                    v-for="child in item.children"
                                    :key="child.label"
                                    :href="child.href"
                                    class="public-header__dropdown-link"
                                    @click="openMenu = null"
                                >
                                    {{ child.label }}
                                    <span class="public-header__dropdown-icon">
                                        <Icon name="arrow" />
                                    </span>
                                </Link>
                            </div>
                        </Transition>
                    </div>
                </nav>
                <div class="public-header__actions">
                    <Link
                        aria-label="Поиск по каталогу"
                        class="public-header__action"
                        :href="CatalogIndex.catalog.url()"
                    >
                        <Icon name="search" />
                    </Link>
                    <Button
                        :aria-label="
                            isDark
                                ? 'Включить светлую тему'
                                : 'Включить тёмную тему'
                        "
                        class="public-header__theme"
                        style-type="link"
                        type="button"
                        @click="toggleTheme"
                    >
                        <Icon :name="isDark ? 'sun' : 'moon'" />
                    </Button>
                    <Link
                        aria-label="Корзина"
                        class="public-header__action"
                        href="/user/cart"
                    >
                        <Icon name="cart" />
                    </Link>
                    <Link styleType="button" class="public-header__contact" href="/contacts">
                        Связаться с нами
                    </Link>
                </div>
            </div>
        </Container>
    </header>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import Link from '@/components/Link.vue';
import { useTheme } from '@/composables/useTheme';
import { clickOutside as vClickOutside } from '@/directives/clickOutside';
import CatalogIndex from '@/routes/catalog';

interface NavItem {
    label: string;
    href: string;
    children?: NavItem[];
}

const page = usePage();
const openMenu = ref<string | null>(null);
const { isDark, toggleTheme } = useTheme();
const navigation = <NavItem[]>[
    {
        label: 'Каталог',
        href: '/catalog',
    },
    {
        label: 'О питомнике',
        href: '/#mission',
    },
    { label: 'Контакты', href: '/contacts' },
];
const navLinkClasses = (href: string) => [
    'public-header__nav-link',
    { 'public-header__nav-link--active': page.url.startsWith(href) },
];
const chevronClasses = (label: string) => [
    'public-header__chevron',
    { 'public-header__chevron--open': openMenu.value === label },
];
const closeMenu = () => {
    openMenu.value = null;
};
</script>

<style lang="scss" scoped>
.public-header-dropdown-enter-active {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

.public-header-dropdown-leave-active {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

.public-header-dropdown-enter-from,
.public-header-dropdown-leave-to {
    transform: translateY(0.5rem);
    opacity: 0;
}
</style>

<template>
    <aside class="admin-sidebar">
        <a :href="AdminRoutes.home.url()" class="admin-sidebar__brand">
            <span class="admin-sidebar__logo">
                <LogoIcon class="admin-sidebar__logo-icon" />
            </span>
            <span class="admin-sidebar__brand-copy">
                <span class="admin-sidebar__brand-name">Деулино Сад</span>
                <span class="admin-sidebar__brand-subtitle">
                    Панель управления
                </span>
            </span>
        </a>
        <nav class="admin-sidebar__nav">
            <template v-for="tab in menuTabs" :key="tab.href">
                <Link
                    v-if="!tab.children"
                    :class="linkClasses(tab.active)"
                    :href="tab.href"
                    :title="tab.name"
                >
                    <span :class="iconClasses(tab.active)">
                        {{ tab.name.slice(0, 1) }}
                    </span>
                    <span class="admin-sidebar__label">{{ tab.name }}</span>
                </Link>
                <div v-else class="admin-sidebar__group">
                    <Button
                        style-type="link"
                        :class="groupClasses(tab.active)"
                        :title="tab.name"
                        type="button"
                        @click="tab.isOpen = !tab.isOpen"
                    >
                        <span class="admin-sidebar__group-content">
                            <span class="admin-sidebar__group-icon">
                                {{ tab.name.slice(0, 1) }}
                            </span>
                            <span
                                class="admin-sidebar__label admin-sidebar__label--nowrap"
                            >
                                {{ tab.name }}
                            </span>
                        </span>
                        <span :class="chevronClasses(tab.isOpen)">
                            <Icon name="chevron" />
                        </span>
                    </Button>
                    <div v-if="tab.isOpen" class="admin-sidebar__children">
                        <Link
                            v-for="childTab in tab.children"
                            :key="childTab.href"
                            :class="childClasses(childTab.active)"
                            :href="childTab.href"
                            :title="childTab.name"
                        >
                            <span class="admin-sidebar__child-dot" />
                            <span class="admin-sidebar__label">
                                {{ childTab.name }}
                            </span>
                        </Link>
                    </div>
                </div>
            </template>
        </nav>
        <div class="admin-sidebar__footer">
            Деулино Сад · ERP
            <span class="admin-sidebar__version">v1.0</span>
        </div>
    </aside>
</template>

<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import AdminRoutes from '@/routes/admin';

const menuTabs = ref([
    { name: 'Заявки', href: AdminRoutes.requests.index.url(), active: false },
    {
        name: 'Каталог',
        isOpen: false,
        active: false,
        children: [
            {
                name: 'Товары',
                href: AdminRoutes.products.index.url(),
                active: false,
            },
            {
                name: 'Категории',
                href: AdminRoutes.categories.index.url(),
                active: false,
            },
            { name: 'Теги', href: AdminRoutes.tags.index.url(), active: false },
        ],
    },
    {
        name: 'Закупки',
        isOpen: false,
        active: false,
        children: [
            { name: 'Поставщики', href: '/admin/suppliers', active: false },
            {
                name: 'Поставки',
                href: '/admin/product-supplies',
                active: false,
            },
        ],
    },
    {
        name: 'Складской учёт',
        isOpen: false,
        active: false,
        children: [
            {
                name: 'Единицы товара',
                href: '/admin/product-units',
                active: false,
            },
            {
                name: 'Статусы единиц',
                href: '/admin/product-unit-statuses',
                active: false,
            },
        ],
    },
    { name: 'Склады', href: AdminRoutes.warehouses.list.url(), active: false },
    { name: 'Пользователи', href: AdminRoutes.users.list.url(), active: false },
    { name: 'Новости', href: AdminRoutes.news.list.url(), active: false },
    { name: 'Общие настройки', href: '/admin/settings', active: false },
    {
        name: 'Главная страница',
        isOpen: false,
        active: false,
        children: [
            {
                name: 'Галерея',
                href: AdminRoutes.mainPage.gallery.list.url(),
                active: false,
            },
        ],
    },
]);

const page = usePage();

const linkClasses = (active: boolean) => [
    'admin-sidebar__link',
    { 'admin-sidebar__link--active': active },
];
const iconClasses = (active: boolean) => [
    'admin-sidebar__icon',
    { 'admin-sidebar__icon--active': active },
];
const groupClasses = (active: boolean) => [
    'admin-sidebar__group-button',
    { 'admin-sidebar__group-button--active': active },
];
const chevronClasses = (open: boolean) => [
    'admin-sidebar__chevron',
    { 'admin-sidebar__chevron--open': open },
];
const childClasses = (active: boolean) => [
    'admin-sidebar__child',
    { 'admin-sidebar__child--active': active },
];

const updateMenuState = (currentPath: string) => {
    menuTabs.value.forEach((tab) => {
        if (tab.children) {
            tab.children.forEach((child) => {
                child.active = currentPath.includes(child.href);
            });

            const hasActiveChild = tab.children.some((child) => child.active);
            tab.active = hasActiveChild;

            if (hasActiveChild) {
                tab.isOpen = true;
            }
        } else {
            tab.active = currentPath.includes(tab.href);
        }
    });
};

watch(
    () => page.url,
    (newUrl) => {
        updateMenuState(newUrl);
    },
    { immediate: true },
);
</script>

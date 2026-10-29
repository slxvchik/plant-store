<template>
    <aside
        class="fixed top-0 left-0 z-40 h-screen w-80 -translate-x-full bg-bg-dark transition-transform sm:translate-x-0"
    >
        <div
            class="bg-neutral-primary-soft border-default h-full scrollbar-none overflow-y-auto border-e px-3 py-3"
        >
            <a
                :href="AdminRoutes.home.url()"
                class="flex h-16 items-center gap-2 border-b border-secondary px-4 text-lg font-bold tracking-wider text-white"
            >
                <div class="h-10 w-10">
                    <LogoIcon class="fill-white" />
                </div>
                Деулино Сад
            </a>

            <!-- Вкладки (Сущности) -->
            <nav class="space-y-2 p-4">
                <template v-for="tab in menuTabs" :key="tab.href">
                    <Link
                        v-if="!tab.children"
                        :href="tab.href"
                        class="flex items-center rounded-sm px-2 py-1.5 text-white transition-all hover:bg-secondary-hover"
                        :class="{ 'bg-secondary': tab.active }"
                    >
                        {{ tab.name }}
                    </Link>
                    <div v-else>
                        <button
                            type="button"
                            class="flex w-full cursor-pointer items-center rounded-sm px-2 py-1.5 text-white transition-all hover:bg-secondary-hover"
                            @click="tab.isOpen = !tab.isOpen"
                        >
                            <span class="flex-1 text-left whitespace-nowrap"
                                >{{ tab.name }}
                            </span>
                            <span
                                class="h-3 w-3 transition-all"
                                :class="tab.isOpen ? '-rotate-90' : 'rotate-90'"
                            >
                                <ChevronIcon />
                            </span>
                        </button>
                        <template v-if="tab.isOpen">
                            <Link
                                v-for="childTab in tab.children"
                                :href="childTab.href"
                                :key="childTab.href"
                                class="flex items-center rounded-sm px-2 py-1.5 pl-5 text-white transition-all hover:bg-secondary-hover"
                                :class="{ 'bg-secondary': childTab.active }"
                            >
                                {{ childTab.name }}
                            </Link>
                        </template>
                    </div>
                </template>
            </nav>
        </div>

        <!-- Футер сайдбара -->
        <div
            class="border-t border-slate-800 p-4 text-center text-xs text-slate-500"
        >
            v1.0.0 © 2026
        </div>
    </aside>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ChevronIcon from '@/components/icons/ChevronIcon.vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import AdminRoutes from '@/routes/admin';

const menuTabs = ref([
    { name: 'Заказы', href: AdminRoutes.orders.list.url(), active: false },
    { name: 'Заявки', href: '/admin/callback', active: false },
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

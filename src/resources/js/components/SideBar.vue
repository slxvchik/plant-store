<template>
    <aside
        class="fixed top-0 left-0 z-40 h-screen w-80 -translate-x-full bg-bg-dark transition-transform sm:translate-x-0"
    >
        <div
            class="bg-neutral-primary-soft border-default h-full scrollbar-none overflow-y-auto border-e px-3 py-3"
        >
            <a
                href="/"
                class="flex h-16 items-center gap-2 border-b border-primary px-4 text-lg font-bold tracking-wider text-white"
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
                        class="flex items-center rounded-sm px-2 py-1.5 text-white transition-all hover:bg-primary-hover"
                        :class="{ 'bg-primary': tab.active }"
                    >
                        {{ tab.name }}
                    </Link>
                    <div v-else>
                        <button
                            type="button"
                            class="flex w-full cursor-pointer items-center rounded-sm px-2 py-1.5 text-white transition-all hover:bg-primary-hover"
                            @click="tab.isOpen = !tab.isOpen"
                        >
                            <span
                                class="flex-1 whitespace-nowrap text-left"
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
                                class="flex items-center rounded-sm px-2 py-1.5 pl-5 text-white transition-all hover:bg-primary-hover"
                                :class="{ 'bg-primary': childTab.active }"
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

const menuTabs = ref([
    { name: 'Заказы', href: '/admin/orders', active: false },
    { name: 'Заявки', href: '/admin/callback', active: false },
    {
        name: 'Каталог',
        isOpen: false,
        active: false,
        children: [
            { name: 'Товары', href: '/admin/products', active: false },
            { name: 'Категории', href: '/admin/categories', active: false },
            { name: 'Теги', href: '/admin/tags', active: false },
        ],
    },
    { name: 'Склады', href: '/admin/warehouses', active: false },
    { name: 'Пользователи', href: '/admin/users', active: false },
    { name: 'Новости', href: '/admin/news', active: false },
    { name: 'Общие настройки', href: '/admin/settings', active: false },
    {
        name: 'Главная страница',
        isOpen: false,
        active: false,
        children: [
            {
                name: 'Галерея',
                href: '/admin/main-page/gallery',
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
                child.active = child.href === currentPath;
            });

            const hasActiveChild = tab.children.some((child) => child.active);
            tab.active = hasActiveChild;
            if (hasActiveChild) {
                tab.isOpen = true;
            }
        } else {
            tab.active = tab.href === currentPath;
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

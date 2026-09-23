<template>
    <aside
        class="fixed top-0 left-0 z-40 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-bg-dark">
        <div class="h-full px-3 py-3 overflow-y-auto bg-neutral-primary-soft border-e border-default scrollbar-none">
            <a href="/"
                class="h-16 px-4 items-center flex gap-2 border-b border-primary font-bold text-white text-lg tracking-wider">
                <LogoIcon class="w-10 h-10 fill-white" />
                Деулино Сад
            </a>

            <!-- Вкладки (Сущности) -->
            <nav class="p-4 space-y-2">
                <template v-for="tab in menuTabs">
                    <Link v-if="!tab.children" :href="tab.href"
                        class="flex text-white items-center px-2 py-1.5 rounded-sm transition-all hover:bg-primary-hover"
                        :class="{ 'bg-primary': tab.active }">
                        {{ tab.name }}
                    </Link>
                    <div v-else>
                        <button type="button"
                            class="w-full cursor-pointer flex text-white items-center px-2 py-1.5 rounded-sm transition-all hover:bg-primary-hover"
                            @click="tab.isOpen = !tab.isOpen">
                            <span class="flex-1 text-left rtl:text-right whitespace-nowrap">{{ tab.name }}</span>
                            <ChevronIcon class="w-3 h-3 transition-all"
                                :class="tab.isOpen ? '-rotate-90' : 'rotate-90'" />
                        </button>
                        <template v-if="tab.isOpen">
                            <Link v-for="childTab in tab.children" :href="childTab.href"
                                class="pl-5 flex text-white items-center px-2 py-1.5 rounded-sm transition-all hover:bg-primary-hover"
                                :class="{ 'bg-primary': tab.active }">
                                {{ childTab.name }}
                            </Link>
                        </template>
                    </div>
                </template>
            </nav>
        </div>

        <!-- Футер сайдбара -->
        <div class="p-4 border-t border-slate-800 text-xs text-center text-slate-500">
            v1.0.0 © 2026
        </div>
    </aside>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import LogoIcon from '@/components/icons/LogoIcon.vue';
import ChevronIcon from '@/components/icons/ChevronIcon.vue';

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
            { name: 'Теги', href: '/admin/tags', active: false }
        ]
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
            { name: 'Галерея', href: '/admin/main-page/gallery', active: false },
        ]
    },
]);

const page = usePage();

const updateMenuState = (currentPath: string) => {
    menuTabs.value.forEach(tab => {
        if (tab.children) {
            tab.children.forEach(child => {
                child.active = child.href === currentPath;
            });

            const hasActiveChild = tab.children.some(child => child.active);
            tab.active = hasActiveChild;
            if (hasActiveChild) {
                tab.isOpen = true;
            }
        } else {
            tab.active = tab.href === currentPath;
        }
    });
};

watch(() => page.url, (newUrl) => {
    updateMenuState(newUrl);
}, { immediate: true });

</script>
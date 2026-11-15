<template>
    <aside
        class="fixed inset-y-0 left-0 z-40 flex w-20 flex-col border-r border-slate-800 bg-slate-950 shadow-xl lg:w-72"
    >
        <a
            :href="AdminRoutes.home.url()"
            class="flex h-20 shrink-0 items-center justify-center gap-3 border-b border-white/10 px-4 lg:justify-start lg:px-6"
        >
            <span
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500 p-2 shadow-lg shadow-emerald-950/30"
            >
                <LogoIcon class="fill-white" />
            </span>
            <span class="hidden min-w-0 lg:block">
                <span
                    class="block truncate text-sm font-semibold tracking-wide text-white"
                >
                    Деулино Сад
                </span>
                <span class="mt-0.5 block text-xs text-slate-400">
                    Панель управления
                </span>
            </span>
        </a>
        <nav
            class="flex-1 scrollbar-none space-y-1.5 overflow-y-auto px-2.5 py-5 lg:px-4"
        >
            <template v-for="tab in menuTabs" :key="tab.href">
                <Link
                    v-if="!tab.children"
                    :class="
                        tab.active
                            ? 'bg-emerald-500/15 text-emerald-300 ring-emerald-400/20'
                            : 'text-slate-400 ring-transparent hover:bg-white/5 hover:text-white'
                    "
                    :href="tab.href"
                    :title="tab.name"
                    class="flex items-center justify-center gap-3 rounded-xl px-3 py-3 text-sm font-medium ring-1 transition ring-inset lg:justify-start"
                >
                    <span
                        :class="
                            tab.active
                                ? 'bg-emerald-400/15 text-emerald-300'
                                : 'bg-white/5 text-slate-500'
                        "
                        class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-xs font-semibold"
                    >
                        {{ tab.name.slice(0, 1) }}
                    </span>
                    <span class="hidden lg:inline">{{ tab.name }}</span>
                </Link>
                <div v-else>
                    <button
                        :class="
                            tab.active
                                ? 'text-white'
                                : 'text-slate-400 hover:text-white'
                        "
                        :title="tab.name"
                        class="flex w-full cursor-pointer items-center justify-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition hover:bg-white/5 lg:justify-between"
                        type="button"
                        @click="tab.isOpen = !tab.isOpen"
                    >
                        <span class="flex items-center gap-3">
                            <span
                                class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white/5 text-xs font-semibold text-slate-400"
                            >
                                {{ tab.name.slice(0, 1) }}
                            </span>
                            <span class="hidden whitespace-nowrap lg:inline">
                                {{ tab.name }}
                            </span>
                        </span>
                        <span
                            :class="tab.isOpen ? 'rotate-90' : ''"
                            class="hidden h-3 w-3 transition-transform lg:block"
                        >
                            <ChevronIcon />
                        </span>
                    </button>
                    <div
                        v-if="tab.isOpen"
                        class="mt-1 space-y-1 lg:ml-5 lg:border-l lg:border-white/10 lg:pl-3"
                    >
                        <Link
                            v-for="childTab in tab.children"
                            :key="childTab.href"
                            :class="
                                childTab.active
                                    ? 'bg-emerald-500/15 text-emerald-300'
                                    : 'text-slate-500 hover:bg-white/5 hover:text-slate-200'
                            "
                            :href="childTab.href"
                            :title="childTab.name"
                            class="flex items-center justify-center rounded-lg px-3 py-2.5 text-xs font-medium transition lg:justify-start"
                        >
                            <span
                                class="h-1.5 w-1.5 shrink-0 rounded-full bg-current opacity-60 lg:mr-2"
                            />
                            <span class="hidden lg:inline">
                                {{ childTab.name }}
                            </span>
                        </Link>
                    </div>
                </div>
            </template>
        </nav>
        <div
            class="hidden shrink-0 border-t border-white/10 px-6 py-4 text-xs text-slate-600 lg:block"
        >
            Деулино Сад · ERP
            <span class="float-right">v1.0</span>
        </div>
    </aside>
</template>

<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ChevronIcon from '@/components/icons/ChevronIcon.vue';
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

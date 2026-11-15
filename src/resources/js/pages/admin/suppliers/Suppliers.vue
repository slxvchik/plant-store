<template>
    <div class="space-y-6">
        <AdminPageHeader
            description="Контакты и условия работы с партнёрами в одном справочнике."
            eyebrow="Закупки"
            title="Поставщики"
        >
            <template #actions>
                <Link
                    class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                    href="/admin/suppliers/create"
                >
                    Добавить поставщика
                </Link>
            </template>
        </AdminPageHeader>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <form
                class="flex flex-col gap-3 sm:flex-row"
                @submit.prevent="applySearch"
            >
                <div class="relative flex-1">
                    <svg
                        class="pointer-events-none absolute top-3.5 left-3.5 h-4 w-4 text-slate-400"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <circle
                            cx="9"
                            cy="9"
                            r="5.5"
                            stroke="currentColor"
                            stroke-width="1.5"
                        />
                        <path
                            d="m13 13 3.5 3.5"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="1.5"
                        />
                    </svg>
                    <input
                        v-model="search"
                        class="h-11 w-full rounded-xl border border-slate-200 pr-4 pl-10 text-sm transition outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                        placeholder="Название, email или телефон"
                        type="search"
                    />
                </div>
                <button
                    class="h-11 rounded-xl bg-slate-900 px-5 text-sm font-medium text-white hover:bg-slate-700"
                    type="submit"
                >
                    Найти
                </button>
                <button
                    v-if="filters.search"
                    class="h-11 rounded-xl px-4 text-sm font-medium text-slate-500 hover:bg-slate-100"
                    type="button"
                    @click="resetSearch"
                >
                    Сбросить
                </button>
            </form>
        </div>
        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left text-sm">
                    <thead
                        class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-4">Поставщик</th>
                            <th class="px-5 py-4">Контакты</th>
                            <th class="px-5 py-4">Адрес</th>
                            <th class="px-5 py-4">Комментарий</th>
                            <th class="px-5 py-4 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="supplier in suppliersPage.items"
                            :key="supplier.id"
                            class="transition hover:bg-slate-50/80"
                        >
                            <td class="px-5 py-4">
                                <Link
                                    :href="`/admin/suppliers/${supplier.id}`"
                                    class="font-semibold text-slate-900 hover:text-emerald-700"
                                >
                                    {{ supplier.name }}
                                </Link>
                                <p
                                    class="mt-1 font-mono text-xs text-slate-400"
                                >
                                    {{ supplier.id.slice(0, 8) }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-slate-700">
                                    {{ supplier.email || 'Email не указан' }}
                                </p>
                                <p class="mt-1 text-slate-500">
                                    {{ supplier.phone || 'Телефон не указан' }}
                                </p>
                            </td>
                            <td class="max-w-56 px-5 py-4 text-slate-600">
                                {{ supplier.address || '—' }}
                            </td>
                            <td
                                :title="supplier.comment ?? ''"
                                class="max-w-64 truncate px-5 py-4 text-slate-500"
                            >
                                {{ supplier.comment || '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="`/admin/suppliers/${supplier.id}`"
                                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-emerald-200 hover:text-emerald-700"
                                    >
                                        Изменить
                                    </Link>
                                    <button
                                        class="rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50"
                                        type="button"
                                        @click="destroy(supplier.id)"
                                    >
                                        Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="suppliersPage.items.length === 0">
                            <td class="px-5 py-16 text-center" colspan="5">
                                <p class="font-medium text-slate-700">
                                    Поставщики не найдены
                                </p>
                                <p class="mt-1 text-sm text-slate-400">
                                    Измените запрос или добавьте первого
                                    поставщика.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <PaginationList :pagination="suppliersPage" />
        </section>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import PaginationList from '@/components/PaginationList.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import type { Supplier } from '@/types/inventory.ts';
import type { Page } from '@/types/pagination.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    suppliersPage: Page<Supplier>;
    filters: { search: string };
}>();
const search = ref(props.filters.search);
const applySearch = () =>
    router.get(
        '/admin/suppliers',
        { search: search.value || undefined },
        { preserveState: true, preserveScroll: true },
    );
const resetSearch = () => {
    search.value = '';
    applySearch();
};
const destroy = (id: string) => {
    if (window.confirm('Удалить поставщика?'))
        router.delete(`/admin/suppliers/${id}`, { preserveScroll: true });
};
</script>

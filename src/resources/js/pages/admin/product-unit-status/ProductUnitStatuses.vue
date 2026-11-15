<template>
    <div class="space-y-6">
        <AdminPageHeader
            description="Настройте жизненный цикл растений — от посева до отгрузки."
            eyebrow="Складской учёт"
            title="Статусы единиц товара"
        >
            <template #actions>
                <Link
                    class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700"
                    href="/admin/product-unit-statuses/create"
                >
                    Добавить статус
                </Link>
            </template>
        </AdminPageHeader>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <article
                v-for="status in statusesPage.items"
                :key="status.id"
                class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
            >
                <div class="flex items-start justify-between gap-4">
                    <Badge :label="status.name" />
                    <span class="font-mono text-xs text-slate-300">
                        #{{ status.id.slice(0, 6) }}
                    </span>
                </div>
                <p class="mt-4 min-h-10 text-sm leading-6 text-slate-500">
                    {{ status.comment || 'Описание статуса не заполнено.' }}
                </p>
                <div class="mt-5 flex gap-2 border-t border-slate-100 pt-4">
                    <Link
                        :href="`/admin/product-unit-statuses/${status.id}`"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700"
                    >
                        Изменить
                    </Link>
                    <button
                        class="rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50"
                        type="button"
                        @click="destroy(status.id)"
                    >
                        Удалить
                    </button>
                </div>
            </article>
            <div
                v-if="statusesPage.items.length === 0"
                class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center text-slate-500"
            >
                Статусы ещё не созданы.
            </div>
        </div>
        <div
            v-if="statusesPage.totalPages > 1"
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white"
        >
            <PaginationList :pagination="statusesPage" />
        </div>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import PaginationList from '@/components/PaginationList.vue';
import type { ProductUnitStatus } from '@/types/inventory.ts';
import type { Page } from '@/types/pagination.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ statusesPage: Page<ProductUnitStatus> }>();
const destroy = (id: string) => {
    if (window.confirm('Удалить статус?')) {
        router.delete(`/admin/product-unit-statuses/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <div class="product-unit-statuses">
        <AdminPageHeader
            description="Настройте жизненный цикл растений — от посева до отгрузки."
            eyebrow="Складской учёт"
            title="Статусы единиц товара"
        >
            <template #actions>
                <Link
                    class="product-unit-statuses__create"
                    href="/admin/product-unit-statuses/create"
                >
                    Добавить статус
                </Link>
            </template>
        </AdminPageHeader>
        <div class="product-unit-statuses__grid">
            <article
                v-for="status in statusesPage.items"
                :key="status.id"
                class="product-unit-statuses__card"
            >
                <div class="product-unit-statuses__card-top">
                    <Badge :label="status.name" />
                    <span class="product-unit-statuses__id">
                        #{{ status.id.slice(0, 6) }}
                    </span>
                </div>
                <p class="product-unit-statuses__comment">
                    {{ status.comment || 'Описание статуса не заполнено.' }}
                </p>
                <div class="product-unit-statuses__actions">
                    <Link
                        :href="`/admin/product-unit-statuses/${status.id}`"
                        class="product-unit-statuses__edit"
                    >
                        Изменить
                    </Link>
                    <Button
                        auto-width
                        danger
                        ghost
                        small
                        text="Удалить"
                        @click="destroy(status.id)"
                    />
                </div>
            </article>
            <div
                v-if="statusesPage.items.length === 0"
                class="product-unit-statuses__empty"
            >
                Статусы ещё не созданы.
            </div>
        </div>
        <div
            v-if="statusesPage.totalPages > 1"
            class="product-unit-statuses__pagination"
        >
            <Pagination :pagination="statusesPage" />
        </div>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Pagination from '@/components/Pagination.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
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

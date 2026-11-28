<template>
    <div class="suppliers">
        <AdminPageHeader
            description="Контакты и условия работы с партнёрами в одном справочнике."
            eyebrow="Закупки"
            title="Поставщики"
        >
            <template #actions>
                <Link class="suppliers__create" href="/admin/suppliers/create">
                    Добавить поставщика
                </Link>
            </template>
        </AdminPageHeader>
        <AdminFilterBar @submit="applySearch">
            <Input
                id="supplier-search"
                v-model="search"
                label="Поиск"
                placeholder="Название, email или телефон"
                type="search"
            />
            <template #actions>
                <Button auto-width text="Найти" type="submit" />
                <Button
                    v-if="filters.search"
                    auto-width
                    ghost
                    text="Сбросить"
                    type="button"
                    @click="resetSearch"
                />
            </template>
        </AdminFilterBar>
        <Table>
            <thead>
                <tr>
                    <th>Поставщик</th>
                    <th>Контакты</th>
                    <th>Адрес</th>
                    <th>Комментарий</th>
                    <th class="suppliers__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="supplier in suppliersPage.items" :key="supplier.id">
                    <td>
                        <Link
                            :href="`/admin/suppliers/${supplier.id}`"
                            class="suppliers__name"
                        >
                            {{ supplier.name }}
                        </Link>
                        <p class="suppliers__id">
                            {{ supplier.id.slice(0, 8) }}
                        </p>
                    </td>
                    <td>
                        <p class="suppliers__contact">
                            {{ supplier.email || 'Email не указан' }}
                        </p>
                        <p class="suppliers__phone">
                            {{ supplier.phone || 'Телефон не указан' }}
                        </p>
                    </td>
                    <td class="suppliers__address">
                        {{ supplier.address || '—' }}
                    </td>
                    <td
                        :title="supplier.comment ?? ''"
                        class="suppliers__comment"
                    >
                        {{ supplier.comment || '—' }}
                    </td>
                    <td>
                        <div class="suppliers__actions">
                            <Link
                                :href="`/admin/suppliers/${supplier.id}`"
                                class="suppliers__edit"
                            >
                                Изменить
                            </Link>
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                @click="destroy(supplier.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="suppliersPage.items.length === 0">
                    <td class="suppliers__empty" colspan="5">
                        <p>Поставщики не найдены</p>
                        <p class="suppliers__empty-hint">
                            Измените запрос или добавьте первого поставщика.
                        </p>
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="suppliersPage" />
            </template>
        </Table>
    </div>
</template>

<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminFilterBar from '@/components/admin/AdminFilterBar.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import Pagination from '@/components/Pagination.vue';
import Table from '@/components/Table.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
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
    if (window.confirm('Удалить поставщика?')) {
        router.delete(`/admin/suppliers/${id}`, { preserveScroll: true });
    }
};
</script>

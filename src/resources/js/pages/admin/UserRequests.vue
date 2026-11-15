<template>
    <div class="user-requests">
        <AdminPageHeader
            description="Контактные данные и комментарии из форм обратной связи."
            eyebrow="Клиенты"
            title="Заявки"
        />
        <Table>
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                    <th>Комментарий</th>
                    <th class="user-requests__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="request in userRequestsPage.items" :key="request.id">
                    <td class="user-requests__name">{{ request.fio }}</td>
                    <td class="user-requests__phone">{{ request.phone }}</td>
                    <td class="user-requests__contact">{{ request.email }}</td>
                    <td class="user-requests__comment">
                        {{ request.comment }}
                    </td>
                    <td class="user-requests__cell--actions">
                        <Button
                            auto-width
                            danger
                            ghost
                            small
                            text="Удалить"
                            @click="destroy(request.id)"
                        />
                    </td>
                </tr>
                <tr v-if="userRequestsPage.items.length === 0">
                    <td class="user-requests__empty" colspan="5">
                        Новых заявок нет.
                    </td>
                </tr>
            </tbody>
            <template #pagination>
                <Pagination :pagination="pagination" />
            </template>
        </Table>
    </div>
</template>
<script lang="ts" setup>
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Button from '@/components/Button.vue';
import Pagination from '@/components/Pagination.vue';
import Table from '@/components/Table.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminRequests from '@/routes/admin/requests';
import type { Page } from '@/types/pagination.ts';
import type { UserRequest } from '@/types/user-request.ts';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ userRequestsPage: Page<UserRequest> }>();
const pagination = computed(() =>
    getPaginationFromPageResponse(props.userRequestsPage),
);
const destroy = (id: string): void => {
    router.delete(AdminRequests.destroy.url(id), { preserveScroll: true });
};
</script>

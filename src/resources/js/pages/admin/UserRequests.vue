<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Заявки</h1>
    </div>
    <div class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div class="grid grid-cols-5 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase">
            <div class="p-4">ФИО</div><div class="p-4">Телефон</div><div class="p-4">Почта</div>
            <div class="p-4">Комментарий</div><div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div v-for="request in userRequestsPage.items" :key="request.id" class="grid grid-cols-5">
                <div class="p-4">{{ request.fio }}</div><div class="p-4">{{ request.phone }}</div>
                <div class="p-4">{{ request.email }}</div><div class="p-4">{{ request.comment }}</div>
                <div class="p-4"><Button text="Удалить" class="bg-red-400 hover:bg-red-500" @click="destroy(request.id)" /></div>
            </div>
        </div>
    </div>
    <PaginationList v-if="pagination.totalPages > 1" :pagination="pagination" />
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import PaginationList from '@/components/PaginationList.vue';
import AdminRequests from '@/routes/admin/requests';
import type { PageResponse } from '@/types/pageResponse';
import type { UserRequest } from '@/types/user-request';
import { getPaginationFromPageResponse } from '@/utils/getPaginationFromPageResponse';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ userRequestsPage: PageResponse<UserRequest> }>();
const pagination = computed(() => getPaginationFromPageResponse(props.userRequestsPage));
const destroy = (id: string): void => {
    router.delete(AdminRequests.destroy.url(id), { preserveScroll: true });
};
</script>

<template>
    <div class="space-y-6">
        <AdminPageHeader title="Заявки" eyebrow="Клиенты" description="Контактные данные и комментарии из форм обратной связи." />
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase">
                        <tr><th class="px-5 py-4">ФИО</th><th class="px-5 py-4">Телефон</th><th class="px-5 py-4">Почта</th><th class="px-5 py-4">Комментарий</th><th class="px-5 py-4 text-right">Действия</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="request in userRequestsPage.items" :key="request.id" class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ request.fio }}</td>
                            <td class="px-5 py-4 whitespace-nowrap text-slate-600">{{ request.phone }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ request.email }}</td>
                            <td class="max-w-80 px-5 py-4 text-slate-500">{{ request.comment }}</td>
                            <td class="px-5 py-4 text-right"><Button text="Удалить" class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-rose-600 hover:!bg-rose-50" @click="destroy(request.id)" /></td>
                        </tr>
                        <tr v-if="userRequestsPage.items.length === 0"><td colspan="5" class="px-5 py-16 text-center text-slate-500">Новых заявок нет.</td></tr>
                    </tbody>
                </table>
            </div>
            <PaginationList :pagination="pagination" />
        </section>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import PaginationList from '@/components/PaginationList.vue';
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

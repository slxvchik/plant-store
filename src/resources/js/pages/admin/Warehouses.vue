<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Склады</h1>
        <div class="max-w-80"><Button text="Создать" secondary @click="openCreateModal" /></div>
    </div>
    <div class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div class="grid grid-cols-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase">
            <div class="p-4">Id</div><div class="p-4">Адрес</div><div class="p-4">Телефон</div><div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div v-for="warehouse in warehouses" :key="warehouse.id" class="grid grid-cols-4 transition-colors hover:bg-gray-50">
                <div class="p-4 font-medium text-gray-900">#{{ warehouse.id }}</div>
                <div class="truncate p-4">{{ warehouse.address }}</div><div class="p-4 whitespace-nowrap">{{ warehouse.phone }}</div>
                <div class="flex gap-2 p-4">
                    <Button text="Редактировать" class="w-fit bg-yellow-400 hover:bg-yellow-500" @click="openEditModal(warehouse)" />
                    <Button text="Удалить" class="w-fit bg-red-400 hover:bg-red-500" @click="destroy(warehouse.id)" />
                </div>
            </div>
        </div>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать склад' : 'Создать склад'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input id="address" v-model="form.address" placeholder="Адрес склада" label="Адрес" :error="form.errors.address" required />
            <Input id="phone" v-model="form.phone" placeholder="+7 999 999 99 99" label="Номер телефона" :error="form.errors.phone" />
            <Button type="submit" secondary :disabled="form.processing" :text="isEditMode ? 'Сохранить' : 'Создать'" class="relative left-[50%] max-w-80 translate-x-[-50%]" />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminWarehouses from '@/routes/admin/warehouses';
import type { Warehouse } from '@/types/warehouse';

defineOptions({ layout: AdminLayout });
defineProps<{ warehouses: Warehouse[] }>();

type WarehouseForm = Omit<Warehouse, 'id'>;
const createData = (): WarehouseForm => ({ address: '', phone: null });
const {
    form, isFormPopupOpen, isEditMode, openCreateModal, openEditModal, submit, destroy,
} = useAdminCrudForm<WarehouseForm, Warehouse>({
    createData,
    editData: ({ address, phone }) => ({ address, phone }),
    routes: {
        store: () => AdminWarehouses.store.url(),
        update: (id) => AdminWarehouses.update.url(id),
        destroy: (id) => AdminWarehouses.destroy.url(id),
    },
});
</script>

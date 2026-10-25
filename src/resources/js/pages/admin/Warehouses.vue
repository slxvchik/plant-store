<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Склады</h1>
        <div class="max-w-80">
            <Button text="Создать" secondary @click="openCreateModal" />
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Id</div>
            <div class="p-4">Адрес</div>
            <div class="p-4">Телефон</div>
            <div class="p-4">Действие</div>
        </div>

        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="warehouse in warehouses"
                :key="warehouse.id"
                class="grid grid-cols-4 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">
                    #{{ warehouse.id }}
                </div>
                <div class="truncate p-4">{{ warehouse.address }}</div>
                <div class="p-4 whitespace-nowrap">{{ warehouse.phone }}</div>
                <div class="flex gap-2 p-4">
                    <Button
                        text="Редактировать"
                        class="w-fit bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(warehouse)"
                    />
                    <Button
                        text="Удалить"
                        class="w-fit bg-red-400 hover:bg-red-500"
                        @click="deleteWarehouse(warehouse.id)"
                    />
                </div>
            </div>
        </div>
    </div>

    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать склад' : 'Создать склад'"
    >
        <form class="flex w-full flex-col">
            <Input
                id="address"
                placeholder="Адрес склада"
                label="Адрес"
                v-model="warehouseAddress"
            />
            <Input
                id="phone"
                placeholder="+7 999 999 99 99"
                label="Номер телефона"
                class="mt-5"
                v-model="warehousePhone"
            />
            <Button
                type="button"
                secondary
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] mt-5 max-w-80 translate-x-[-50%]"
                @click="isEditMode ? updateWarehouse() : createWarehouse()"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import AdminWarehouses from '@/routes/admin/warehouses';
import type { Warehouse } from '@/types/warehouse';

defineOptions({
    layout: AdminLayout,
});

defineProps({
    auth: {
        type: Object,
        required: false,
    },
    warehouses: {
        type: Array as () => Warehouse[],
        required: false,
        default: () => [],
    },
});

const isFormPopupOpen = ref(false);
const isEditMode = ref(false);

const warehouseId = ref<string | undefined>(undefined);
const warehouseAddress = ref('');
const warehousePhone = ref('');

const openCreateModal = () => {
    isEditMode.value = false;
    warehouseId.value = undefined;
    warehouseAddress.value = '';
    warehousePhone.value = '';
    isFormPopupOpen.value = true;
};

const openEditModal = (warehouse: Warehouse) => {
    isEditMode.value = true;
    warehouseId.value = warehouse.id;
    warehouseAddress.value = warehouse.address;
    warehousePhone.value = warehouse.phone;
    isFormPopupOpen.value = true;
};

const createWarehouse = () => {
    const warehouse = {
        address: warehouseAddress.value,
        phone: warehousePhone.value,
    };
    router.post(AdminWarehouses.store.url(), warehouse, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            warehouseId.value = undefined;
            warehouseAddress.value = '';
            warehousePhone.value = '';
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const updateWarehouse = () => {
    if (!warehouseId.value) {
        return;
    }

    const warehouse = {
        address: warehouseAddress.value,
        phone: warehousePhone.value,
    };

    router.put(AdminWarehouses.update.url(warehouseId.value), warehouse, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            warehouseId.value = undefined;
            warehouseAddress.value = '';
            warehousePhone.value = '';
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const deleteWarehouse = (warehouseId: string) => {
    router.delete(AdminWarehouses.destroy.url(warehouseId), {
        onSuccess: () => {},
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>

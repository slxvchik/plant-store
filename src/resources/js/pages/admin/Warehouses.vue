<template>
    <Button text="Создать" class="max-w-80 mb-5 rounded-lg" @click="openCreateModal" />
    <div class="w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div
            class="grid grid-cols-4 bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
            <div class="p-4">Id</div>
            <div class="p-4">Адрес</div>
            <div class="p-4">Телефон</div>
            <div class="p-4">Действие</div>
        </div>

        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div v-for="warehouse in warehouses" :key="warehouse.id"
                class="grid grid-cols-4 hover:bg-gray-50 transition-colors">
                <div class="p-4 font-medium text-gray-900">#{{ warehouse.id }}</div>
                <div class="p-4 truncate">{{ warehouse.address }}</div>
                <div class="p-4 whitespace-nowrap">{{ warehouse.phone }}</div>
                <div class="flex p-4 gap-2">
                    <Button text="Редактировать" class="w-fit rounded-lg bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(warehouse)" />
                    <Button text="Удалить" class="w-fit rounded-lg bg-red-400 hover:bg-red-500"
                        @click="deleteWarehouse(warehouse.id)" />
                </div>
            </div>
        </div>
    </div>

    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать склад' : 'Создать склад'">
        <form class="flex flex-col w-full">
            <Input id="address" placeholder="Адрес склада" label="Адрес" v-model="warehouseAddress" />
            <Input id="phone" placeholder="+7 999 999 99 99" label="Номер телефона" class="mt-5"
                v-model="warehousePhone" />
            <Button :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative max-w-80 mt-5 rounded-lg left-[50%] translate-x-[-50%]"
                @click="isEditMode ? updateWarehouse() : createWarehouse()" />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import AdminLayout from '@/components/AdminLayout.vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Popup from '@/components/Popup.vue';

interface Warehouse {
    id: string;
    address: string;
    phone: string;
}

defineOptions({
    layout: AdminLayout,
});

const props = defineProps({
    auth: {
        type: Object,
        required: false,
    },
    warehouses: {
        type: Array as () => Warehouse[],
        required: false,
        default: () => []
    },
});

const isFormPopupOpen = ref(false);
const isEditMode = ref(false);

const warehouseId = ref<string | null>(null);
const warehouseAddress = ref('');
const warehousePhone = ref('');

const openCreateModal = () => {
    isEditMode.value = false;
    warehouseAddress.value = '';
    warehousePhone.value = '';
    isFormPopupOpen.value = true;
}

const openEditModal = (warehouse: Warehouse) => {
    isEditMode.value = true;
    warehouseId.value = warehouse.id;
    warehouseAddress.value = warehouse.address;
    warehousePhone.value = warehouse.phone;
    isFormPopupOpen.value = true;
}

const createWarehouse = () => {
    const warehouse = {
        address: warehouseAddress.value,
        phone: warehousePhone.value
    };
    router.post('/admin/warehouses', warehouse, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            warehouseAddress.value = '';
            warehousePhone.value = '';
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

const updateWarehouse = () => {
    const warehouse = {
        address: warehouseAddress.value,
        phone: warehousePhone.value
    };
    router.put(`/admin/warehouses/${warehouseId.value}`, warehouse, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

const deleteWarehouse = (warehouseId: string) => {
    router.delete(`/admin/warehouses/${warehouseId}`, {
        onSuccess: () => {
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}
</script>
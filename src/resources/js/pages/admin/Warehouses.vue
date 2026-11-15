<template>
    <div class="space-y-6">
        <AdminPageHeader
            title="Склады"
            eyebrow="Складской учёт"
            description="Адреса и контакты мест хранения товарных единиц."
        >
            <template #actions>
                <Button
                    text="Добавить склад"
                    secondary
                    class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm shadow-sm"
                    @click="openCreateModal"
                />
            </template>
        </AdminPageHeader>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <article
                v-for="warehouse in warehouses"
                :key="warehouse.id"
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-200 hover:shadow-md"
            >
                <div class="flex items-start justify-between gap-4">
                    <span
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none">
                            <path
                                d="m3 8 7-4 7 4v8H3V8Z"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M7 16v-5h6v5"
                                stroke="currentColor"
                                stroke-width="1.5"
                            />
                        </svg>
                    </span>
                    <span class="font-mono text-xs text-slate-300">
                        #{{ warehouse.id.slice(0, 6) }}
                    </span>
                </div>
                <h2 class="mt-5 leading-6 font-semibold text-slate-900">
                    {{ warehouse.address }}
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    {{ warehouse.phone || 'Телефон не указан' }}
                </p>
                <div class="mt-5 flex gap-2 border-t border-slate-100 pt-4">
                    <button
                        type="button"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-emerald-700"
                        @click="openEditModal(warehouse)"
                    >
                        Изменить
                    </button>
                    <button
                        type="button"
                        class="rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50"
                        @click="destroy(warehouse.id)"
                    >
                        Удалить
                    </button>
                </div>
            </article>
            <div
                v-if="warehouses.length === 0"
                class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center text-slate-500"
            >
                Склады ещё не добавлены.
            </div>
        </div>
    </div>
    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать склад' : 'Создать склад'"
    >
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input
                id="address"
                v-model="form.address"
                label="Адрес"
                :error="form.errors.address"
                @update:modelValue="
                    validateField && validateField('address', form.address)
                "
            />
            <Input
                id="phone"
                v-model="form.phone"
                type="tel"
                label="Номер телефона"
                :error="form.errors.phone"
                @update:modelValue="
                    validateField && validateField('phone', form.phone)
                "
            />
            <div class="flex justify-end border-t border-slate-100 pt-5">
                <Button
                    type="submit"
                    secondary
                    :disabled="form.processing"
                    :text="isEditMode ? 'Сохранить' : 'Создать'"
                    class="!w-auto !rounded-xl !px-5 !text-sm"
                />
            </div>
        </form>
    </Popup>
</template>

<script setup lang="ts">
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminWarehouses from '@/routes/admin/warehouses';
import type { Warehouse } from '@/types/warehouse';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ warehouses: Warehouse[] }>();

type WarehouseForm = Omit<Warehouse, 'id'>;
const createData = (): WarehouseForm => ({ address: '', phone: null });
const warehouseValidator = (field: keyof WarehouseForm, value: any) => {
    switch (field) {
        case 'address':
            return validate(value, 'required', 'Адрес склада обязателен');
        case 'phone':
            return validate(value, 'phone');
        default:
            return null;
    }
};
const {
    form,
    formValidator,
    isFormPopupOpen,
    isEditMode,
    openCreateModal,
    openEditModal,
    submit,
    destroy,
} = useAdminCrudForm<WarehouseForm, Warehouse>({
    createData,
    editData: ({ address, phone }) => ({ address, phone }),
    routes: {
        store: () => AdminWarehouses.store.url(),
        update: (id) => AdminWarehouses.update.url(id),
        destroy: (id) => AdminWarehouses.destroy.url(id),
    },
    validator: warehouseValidator,
});
const validateField = formValidator?.validateField;
</script>

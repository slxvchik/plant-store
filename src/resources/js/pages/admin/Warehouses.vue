<template>
    <div class="warehouses">
        <AdminPageHeader
            description="Адреса и контакты мест хранения товарных единиц."
            eyebrow="Складской учёт"
            title="Склады"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Добавить склад"
                    @click="openCreateModal"
                />
            </template>
        </AdminPageHeader>
        <div class="warehouses__grid">
            <article
                v-for="warehouse in warehouses"
                :key="warehouse.id"
                class="warehouses__card"
            >
                <div class="warehouses__card-top">
                    <span class="warehouses__icon">
                        <svg fill="none" viewBox="0 0 20 20">
                            <path
                                d="m3 8 7-4 7 4v8H3V8Z"
                                stroke="currentColor"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                            />
                            <path
                                d="M7 16v-5h6v5"
                                stroke="currentColor"
                                stroke-width="1.5"
                            />
                        </svg>
                    </span>
                    <span class="warehouses__id">
                        #{{ warehouse.id.slice(0, 6) }}
                    </span>
                </div>
                <h2 class="warehouses__address">{{ warehouse.address }}</h2>
                <p class="warehouses__phone">
                    {{ warehouse.phone || 'Телефон не указан' }}
                </p>
                <div class="warehouses__actions">
                    <Button
                        auto-width
                        outline
                        small
                        text="Изменить"
                        type="button"
                        @click="openEditModal(warehouse)"
                    />
                    <Button
                        auto-width
                        danger
                        ghost
                        small
                        text="Удалить"
                        type="button"
                        @click="destroy(warehouse.id)"
                    />
                </div>
            </article>
            <div v-if="warehouses.length === 0" class="warehouses__empty">
                Склады ещё не добавлены.
            </div>
        </div>
        <Modal
            v-model:open="isFormPopupOpen"
            :title="isEditMode ? 'Редактировать склад' : 'Создать склад'"
        >
            <form class="warehouses__form" @submit.prevent="submit">
                <Input
                    id="address"
                    v-model="form.address"
                    :error="form.errors.address"
                    label="Адрес"
                    @update:modelValue="
                        validateField && validateField('address', form.address)
                    "
                />
                <Input
                    id="phone"
                    v-model="form.phone"
                    :error="form.errors.phone"
                    label="Номер телефона"
                    type="tel"
                    @update:modelValue="
                        validateField && validateField('phone', form.phone)
                    "
                />
                <div class="warehouses__form-footer">
                    <Button
                        :disabled="form.processing"
                        :text="isEditMode ? 'Сохранить' : 'Создать'"
                        auto-width
                        secondary
                        type="submit"
                    />
                </div>
            </form>
        </Modal>
    </div>
</template>

<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import Modal from '@/components/Modal.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import AdminLayout from '@/layouts/AdminLayout.vue';
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

<template>
    <div class="supplier-create">
        <AdminPageHeader
            back-url="/admin/suppliers"
            description="Добавьте основные контактные данные. Обязательно только название."
            eyebrow="Закупки"
            title="Новый поставщик"
        />
        <SupplierForm
            :initial="initial"
            submit-label="Создать поставщика"
            submit-url="/admin/suppliers"
        />
    </div>
</template>
<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import SupplierForm from '@/components/supplier/SupplierForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { SupplierFormData } from '@/types/inventory.ts';

defineOptions({ layout: AdminLayout });
const initial: SupplierFormData = {
    name: '',
    phone: null,
    email: null,
    address: null,
    comment: null,
};
</script>

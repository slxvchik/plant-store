<template>
    <div class="w-full space-y-6">
        <AdminPageHeader
            :title="supplier.name"
            back-url="/admin/suppliers"
            description="Изменения сохраняются в общем справочнике поставщиков."
            eyebrow="Карточка поставщика"
        />
        <SupplierForm
            :initial="initial"
            :submit-url="`/admin/suppliers/${supplier.id}`"
            method="put"
        />
    </div>
</template>
<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import SupplierForm from '@/components/supplier/SupplierForm.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import type { Supplier } from '@/types/inventory.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ supplier: Supplier }>();
const initial = {
    name: props.supplier.name,
    phone: props.supplier.phone,
    email: props.supplier.email,
    address: props.supplier.address,
    comment: props.supplier.comment,
};
</script>

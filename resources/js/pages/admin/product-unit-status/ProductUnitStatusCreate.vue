<template>
    <div class="product-unit-status-create">
        <AdminPageHeader
            back-url="/admin/product-unit-statuses"
            description="Название должно быть уникальным и понятным сотрудникам склада."
            eyebrow="Складской учёт"
            title="Новый статус"
        />
        <ProductUnitStatusForm
            :initial="initial"
            submit-label="Создать статус"
            submit-url="/admin/product-unit-statuses"
        />
    </div>
</template>
<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import ProductUnitStatusForm from '@/components/product/ProductUnitStatusForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { StatusFormData } from '@/types/inventory.ts';

defineOptions({ layout: AdminLayout });
const initial: StatusFormData = { name: '', comment: null };
</script>

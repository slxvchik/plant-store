<template>
    <div class="product-unit-status-show">
        <AdminPageHeader
            :title="status.name"
            back-url="/admin/product-unit-statuses"
            description="Новое название увидят все пользователи административной панели."
            eyebrow="Редактирование статуса"
        />
        <ProductUnitStatusForm
            :initial="initial"
            :submit-url="`/admin/product-unit-statuses/${status.id}`"
            method="put"
        />
    </div>
</template>
<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import ProductUnitStatusForm from '@/components/product/ProductUnitStatusForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type { ProductUnitStatus } from '@/types/inventory.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ status: ProductUnitStatus }>();
const initial = { name: props.status.name, comment: props.status.comment };
</script>

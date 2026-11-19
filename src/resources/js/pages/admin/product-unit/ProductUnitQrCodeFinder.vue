<template>
    <div class="product-unit-qr-code-finder">
        <AdminPageHeader
            description="Наведите камеру на barcode."
            eyebrow="Складской учёт"
            title="Поиск растения по barcode."
            back-url="/admin/product-units"
            back-label="Назад"
        />
        <Scanner />
    </div>
</template>

<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Scanner from '@/components/Scanner.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout,
})
</script>

<style lang="scss">
.product-unit-qr-code-finder {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
</style>

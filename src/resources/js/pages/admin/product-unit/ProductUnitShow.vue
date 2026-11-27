<template>
    <div class="product-unit-show">
        <AdminPageHeader
            :title="`Единица #${productUnit.id.slice(0, 8)}`"
            back-url="/admin/product-units"
            description="Обновите расположение, статус, резерв или связь с поставкой."
            eyebrow="Карточка единицы товара"
        />
        <BarCodeGenerator v-if="productUnit.id" :content="productUnit.id" class="product-unit-show__qr"/>
        <ProductUnitForm
            :initial="initial"
            :products="products"
            :statuses="statuses"
            :submit-url="`/admin/product-units/${productUnit.id}`"
            :supplies="supplies"
            :warehouses="warehouses"
        />
    </div>
</template>
<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import BarCodeGenerator from '@/components/BarCodeGenerator.vue';
import ProductUnitForm from '@/components/product/ProductUnitForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import type {
    ProductOption,
    ProductSupply,
    ProductUnit,
    ProductUnitFormData,
    ProductUnitStatus
} from '@/types/inventory.ts';
import type { Warehouse } from '@/types/warehouse.ts';

defineOptions({ layout: AdminLayout });
const props = defineProps<{
    productUnit: ProductUnit;
    products: ProductOption[];
    warehouses: Warehouse[];
    statuses: ProductUnitStatus[];
    supplies: ProductSupply[];
}>();
const initial: ProductUnitFormData = {
    productSupplyId: props.productUnit.productSupplyId,
    offerId: props.productUnit.offerId,
    warehouseId: props.productUnit.warehouseId,
    reserved: props.productUnit.reserved,
    sowingDate: props.productUnit.sowingDate?.slice(0, 10) ?? null,
    productUnitStatusId: props.productUnit.productUnitStatusId,
    comments: props.productUnit.comments,
};
</script>

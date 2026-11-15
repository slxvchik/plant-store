<template>
    <div class="create-product">
        <AdminPageHeader
            :back-url="AdminProduct.index.url()"
            description="Заполните карточку товара и добавьте торговые предложения."
            eyebrow="Каталог"
            title="Создание товара"
        >
            <template #actions>
                <Button
                    :disabled="form.processing"
                    auto-width
                    secondary
                    text="Создать товар"
                    type="button"
                    @click="submit"
                />
            </template>
        </AdminPageHeader>
        <Tabs :items="tabs">
            <template #product>
                <ProductForm
                    v-model="form"
                    :all-categories="categoryOptions"
                    :errors="form.errors"
                />
            </template>
            <template #offers>
                <div class="create-product__offers">
                    <div class="create-product__offer-action">
                        <Button
                            secondary
                            text="Добавить ТП"
                            @click="offerDialog?.openCreate()"
                        />
                    </div>
                    <ProductOfferList
                        :offers="form.offers"
                        @edit="offerDialog?.openEdit($event)"
                        @remove="removeOffer"
                    />
                </div>
                <OfferEditorDialog
                    ref="offerDialog"
                    v-model:offers="form.offers"
                    :warehouses="warehouses"
                />
            </template>
        </Tabs>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Button from '@/components/Button.vue';
import OfferEditorDialog from '@/components/product/OfferEditorDialog.vue';
import ProductForm from '@/components/product/ProductForm.vue';
import ProductOfferList from '@/components/product/ProductOfferList.vue';
import Tabs from '@/components/Tabs.vue';
import { useProductForm } from '@/composables/useProductForm';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminProduct from '@/routes/admin/products';
import type { Category } from '@/types/category';
import type { Warehouse } from '@/types/warehouse';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories: Category[];
    warehouses: Warehouse[];
}>();

const { form, submit } = useProductForm('create');

const offerDialog = ref<InstanceType<typeof OfferEditorDialog> | null>(null);

const tabs = [
    { id: 'product', label: 'Товар' },
    { id: 'offers', label: 'Торговые предложения' },
];

const categoryOptions = computed(() =>
    props.categories.map((category) => ({
        label: category.name,
        value: category.id,
    })),
);

const removeOffer = (clientKey: string): void => {
    form.offers = form.offers.filter((offer) => offer.clientKey !== clientKey);
};
</script>

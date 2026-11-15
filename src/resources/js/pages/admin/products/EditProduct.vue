<template>
    <div class="edit-product">
        <AdminPageHeader
            :back-url="backUrl"
            :title="product.name"
            description="Основные данные, торговые предложения и складские остатки."
            eyebrow="Карточка товара"
        >
            <template #actions>
                <Badge
                    :label="product.active ? 'Активен' : 'Не активен'"
                    :tone="product.active ? 'success' : 'neutral'"
                />
                <Button
                    :text="
                        isEditMode
                            ? 'Выключить редактирование'
                            : 'Включить редактирование'
                    "
                    auto-width
                    secondary
                    type="button"
                    @click="isEditMode = !isEditMode"
                />
                <template v-if="isEditMode">
                    <Button
                        :disabled="form.processing"
                        auto-width
                        secondary
                        text="Сохранить"
                        type="button"
                        @click="submit"
                    />
                    <Button
                        auto-width
                        danger
                        text="Удалить товар"
                        type="button"
                        @click="deleteProduct"
                    />
                </template>
            </template>
        </AdminPageHeader>

        <Tabs :items="tabs">
            <template #product>
                <ProductForm
                    v-model="form"
                    :all-categories="categoryOptions"
                    :disabled="!isEditMode"
                />
            </template>
            <template #offers>
                <div class="edit-product__offers">
                    <div v-if="isEditMode" class="edit-product__offer-action">
                        <Button
                            secondary
                            text="Добавить ТП"
                            @click="offerDialog?.openCreate()"
                        />
                    </div>
                    <ProductOfferList
                        :disabled="!isEditMode"
                        :offers="form.offers"
                        @edit="offerDialog?.openEdit($event)"
                        @remove="removeOffer"
                    />
                </div>
                <OfferEditorDialog
                    ref="offerDialog"
                    v-model:offers="form.offers"
                    :disabled="!isEditMode"
                    :warehouses="warehouses"
                />
            </template>
        </Tabs>
    </div>
</template>

<script lang="ts" setup>
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import OfferEditorDialog from '@/components/product/OfferEditorDialog.vue';
import ProductForm from '@/components/product/ProductForm.vue';
import ProductOfferList from '@/components/product/ProductOfferList.vue';
import Tabs from '@/components/Tabs.vue';
import { useProductForm } from '@/composables/useProductForm.ts';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AdminProduct from '@/routes/admin/products';
import type { Category, Warehouse } from '@/types';
import type { Product } from '@/types/product.ts';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    product: Product;
    categories: Category[];
    warehouses: Warehouse[];
}>();

const tabs = [
    { id: 'product', label: 'Товар' },
    { id: 'offers', label: 'Торговые предложения' },
];

const isEditMode = ref(false);

const { form, submit } = useProductForm('edit', props.product);
const offerDialog = ref<InstanceType<typeof OfferEditorDialog> | null>(null);
const removeOffer = (clientKey: string): void => {
    form.offers = form.offers.filter((offer) => offer.clientKey !== clientKey);
};

const categoryOptions = computed(() =>
    props.categories.map((category) => ({
        label: category.name,
        value: category.id,
    })),
);

const backUrl = computed(() => {
    const referrer = document.referrer;

    if (
        referrer.includes('page') &&
        referrer.includes(AdminProduct.index.url())
    ) {
        return referrer;
    }

    return AdminProduct.index.url();
});

const deleteProduct = (): void => {
    AdminProduct.destroy.url(props.product.id);
    router.get(AdminProduct.index.url());
};
</script>

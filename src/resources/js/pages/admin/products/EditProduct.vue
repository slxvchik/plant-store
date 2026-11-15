<template>
    <div class="space-y-6">
        <AdminPageHeader
            :title="product.name"
            eyebrow="Карточка товара"
            description="Основные данные, торговые предложения и складские остатки."
            :back-url="backUrl"
        >
            <template #actions>
                <Badge :label="product.active ? 'Активен' : 'Не активен'" :tone="product.active ? 'success' : 'neutral'" />
                <Button
                    :text="isEditMode ? 'Выключить редактирование' : 'Включить редактирование'"
                    class="!w-auto !rounded-xl !px-4 !py-2.5 !text-sm"
                    secondary
                    type="button"
                    @click="isEditMode = !isEditMode"
                />
                <template v-if="isEditMode">
                    <Button :disabled="form.processing" class="!w-auto !rounded-xl !px-4 !py-2.5 !text-sm" secondary text="Сохранить" type="button" @click="submit" />
                    <Button class="!w-auto !rounded-xl !bg-rose-600 !px-4 !py-2.5 !text-sm hover:!bg-rose-700" text="Удалить товар" type="button" @click="deleteProduct" />
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
                <div class="flex flex-col gap-5">
                    <div v-if="isEditMode" class="max-w-80">
                        <Button
                            class="bg-secondary hover:bg-secondary-hover"
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
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import OfferEditorDialog from '@/components/product/OfferEditorDialog.vue';
import ProductForm from '@/components/product/ProductForm.vue';
import ProductOfferList from '@/components/product/ProductOfferList.vue';
import Tabs from '@/components/Tabs.vue';
import { useProductForm } from '@/composables/useProductForm.ts';
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

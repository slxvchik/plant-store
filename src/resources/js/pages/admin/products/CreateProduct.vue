<template>
    <div class="flex flex-col gap-5">
        <div class="w-fit">
            <Link :href="AdminProduct.index.url()" text="Назад" secondary />
        </div>
        <div class="flex flex-row gap-10">
            <h1 class="text-4xl text-text-title">Создание товара</h1>
            <div class="w-fit">
                <Button
                    type="button"
                    text="Создать"
                    secondary
                    :disabled="form.processing"
                    @click="submit"
                />
            </div>
        </div>
        <Tabs :items="tabs">
            <template #product>
                <ProductForm
                    v-model="form"
                    :all-categories="categoryOptions"
                    :errors="form.errors"
                />
            </template>
            <template #offers>
                <div class="flex flex-col gap-5">
                    <div class="max-w-80">
                        <Button
                            text="Добавить ТП"
                            class="bg-secondary hover:bg-secondary-hover"
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

<script setup lang="ts">
import { computed, ref } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import OfferEditorDialog from '@/components/OfferEditorDialog.vue';
import ProductForm from '@/components/ProductForm.vue';
import ProductOfferList from '@/components/ProductOfferList.vue';
import Tabs from '@/components/Tabs.vue';
import { useProductForm } from '@/composables/useProductForm';
import AdminProduct from '@/routes/admin/products';
import type { Category } from '@/types/category';
import type { Warehouse } from '@/types/warehouse';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories: Category[];
    warehouses: Warehouse[];
}>();
const { form, submit } = useProductForm();
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

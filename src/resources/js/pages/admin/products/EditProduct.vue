<template>
    <div class="flex flex-col gap-5">
        <div class="w-fit">
            <Link :href="backUrl" text="К списку" secondary />
        </div>
        <div class="w-fit">
            <Button
                type="button"
                secondary
                :class="isEditMode ? '' : 'bg-yellow-400'"
                :text="
                    isEditMode
                        ? 'Выключить редактирование'
                        : 'Включить редактирование'
                "
                @click="isEditMode = !isEditMode"
            />
        </div>
        <div class="flex flex-row gap-10">
            <h1
                class="flex items-center gap-3 text-2xl font-bold text-gray-900 sm:text-3xl"
            >
                {{ product.name }}
                <span
                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium text-nowrap"
                    :class="
                        product.active
                            ? 'bg-green-100 text-green-800'
                            : 'bg-red'
                    "
                    >{{ product.active ? 'Активен' : 'Не активен' }}</span
                >
            </h1>
            <div
                class="flex w-full flex-row justify-between gap-4"
                v-if="isEditMode"
            >
                <Button
                    type="button"
                    text="Сохранить"
                    class="w-fit"
                    secondary
                    :disabled="form.processing"
                    @click="submit"
                />
                <Button
                    type="button"
                    text="Удалить товар"
                    class="w-fit bg-red-500 text-nowrap hover:bg-red-700"
                    @click="deleteProduct"
                />
            </div>
        </div>

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
                    <div class="max-w-80" v-if="isEditMode">
                        <Button
                            text="Добавить ТП"
                            class="bg-secondary hover:bg-secondary-hover"
                            @click="offerDialog?.openCreate()"
                        />
                    </div>
                    <ProductOfferList
                        :offers="form.offers"
                        :disabled="!isEditMode"
                        @edit="offerDialog?.openEdit($event)"
                        @remove="removeOffer"
                    />
                </div>
                <OfferEditorDialog
                    ref="offerDialog"
                    v-model:offers="form.offers"
                    :warehouses="warehouses"
                    :disabled="!isEditMode"
                />
            </template>
        </Tabs>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
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

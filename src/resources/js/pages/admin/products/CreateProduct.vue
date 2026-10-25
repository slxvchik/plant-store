<template>
    <div class="flex flex-col gap-5">
        <Link :href="AdminProduct.index.url()" text="Назад" secondary />

        <div class="flex flex-row gap-10">
            <h1 class="text-4xl text-text-title">Создание товара</h1>
            <div class="w-fit">
                <Button
                    type="button"
                    text="Создать"
                    @click="createProduct"
                    secondary
                />
            </div>
        </div>

        <Tabs :items="tabs">
            <template #product>
                <ProductForm
                    :allCategories="allProductCategories"
                    v-model:name="productForm.name"
                    v-model:active="productForm.active"
                    v-model:alias="productForm.alias"
                    v-model:sort="productForm.sort"
                    v-model:description="productForm.description"
                    v-model:categories="productForm.categories"
                    v-model:images="productForm.images"
                />
            </template>

            <template #offers>
                <div class="flex flex-col gap-5">
                    <div class="max-w-80">
                        <Button
                            text="Добавить ТП"
                            class="bg-secondary hover:bg-secondary-hover"
                            @click="openModalOfferCreatePopup"
                        />
                    </div>
                    <div
                        class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white"
                    >
                        <div
                            class="grid grid-cols-[80px_120px_1fr_350px_200px] border-b border-gray-200 bg-slate-50 font-medium text-gray-700"
                        >
                            <div class="border-r border-gray-200 p-3">Id</div>
                            <div class="border-r border-gray-200 p-3">
                                Активность
                            </div>
                            <div class="border-r border-gray-200 p-3">
                                Артикул
                            </div>
                            <div class="border-r border-gray-200 p-3">
                                Цена (коп.)
                            </div>
                            <div class="p-3 text-center">Действие</div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <div
                                v-for="(offer, index) in productOffers"
                                :key="index"
                                class="grid grid-cols-[80px_120px_1fr_350px_200px] items-center text-sm text-gray-700 hover:bg-slate-50"
                            >
                                <div
                                    class="border-r border-gray-200 p-3 text-gray-400"
                                >
                                    {{ offer.id || 'Новое' }}
                                </div>

                                <div
                                    class="flex justify-center border-r border-gray-200 p-3"
                                >
                                    {{ offer.active }}
                                </div>

                                <div class="border-r border-gray-200 p-2">
                                    {{ offer.sku }}
                                </div>

                                <div class="border-r border-gray-200 p-2">
                                    {{ offer.price }}
                                </div>

                                <div class="flex flex-col p-3 text-center">
                                    <Button
                                        styleType="link"
                                        text="Редактировать"
                                        class="cursor-pointer text-yellow-400 hover:text-yellow-600"
                                        @click="openModalOfferEditPopup(index)"
                                    />
                                    <Button
                                        styleType="link"
                                        text="Удалить"
                                        class="cursor-pointer text-red-400 hover:text-red-600"
                                        @click="removeOffer(index)"
                                    />
                                </div>
                            </div>

                            <div
                                v-if="productOffers.length === 0"
                                class="bg-gray-50 p-8 text-center text-gray-400"
                            >
                                Торговые предложения еще не добавлены
                            </div>
                        </div>
                        <div
                            class="divide-y divide-gray-200 bg-white text-sm text-gray-700"
                        ></div>
                    </div>
                </div>
                <Popup
                    v-model:open="offerPopupIsOpen"
                    :title="
                        editingOfferIndex !== null
                            ? 'Редактирование ТП'
                            : 'Создание ТП'
                    "
                >
                    <OfferForm
                        :allWarehouses="warehouses"
                        v-model:active="offerForm.active"
                        v-model:sku="offerForm.sku"
                        v-model:sort="offerForm.sort"
                        v-model:description="offerForm.description"
                        v-model:price="offerForm.price"
                        v-model:formFactor="offerForm.formFactor"
                        v-model:size="offerForm.size"
                        v-model:age="offerForm.age"
                        v-model:sowingDate="offerForm.sowingDate"
                        v-model:images="offerForm.images"
                        v-model:stocks="offerForm.stocks"
                    />

                    <Button
                        type="button"
                        :text="
                            editingOfferIndex !== null ? 'Сохранить' : 'Создать'
                        "
                        @click="saveOffer"
                        secondary
                    />
                </Popup>
            </template>
        </Tabs>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, reactive, ref, toRaw } from 'vue';
import Button from '@/components/Button.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import OfferForm from '@/components/pages/admin/products/OfferForm.vue';
import ProductForm from '@/components/pages/admin/products/ProductForm.vue';
import Popup from '@/components/Popup.vue';
import Tabs from '@/components/Tabs.vue';
import AdminProduct from '@/routes/admin/products';
import type { Category } from '@/types';
import type { OfferFormState, ProductFormState } from '@/types/form/product.ts';
import type { Warehouse } from '@/types/warehouse.ts';

defineOptions({
    layout: AdminLayout,
});

interface Props {
    categories: Category[];
    warehouses: Warehouse[];
}

const props = defineProps<Props>();

const createEmptyOffer = (): OfferFormState => ({
    id: undefined,
    active: false,
    sku: '',
    sort: 500,
    description: '',
    price: 0,
    stocks: props.warehouses.map((warehouse) => ({
        warehouseId: warehouse.id,
        quantity: 0,
        reserved: 0,
    })),
    formFactor: undefined,
    size: undefined,
    age: undefined,
    sowingDate: undefined,
    images: null,
    videos: null,
});

const productForm = reactive<ProductFormState>({
    id: undefined,
    name: '',
    active: false,
    alias: '',
    sort: 500,
    description: '',
    categories: [] as string[],
    images: null,
});

const productOffers = ref<OfferFormState[]>([]);

const offerForm = reactive<OfferFormState>(createEmptyOffer());

const offerPopupIsOpen = ref(false);
const editingOfferIndex = ref<number | null>(null);

const tabs = [
    { id: 'product', label: 'Товар' },
    { id: 'offers', label: 'Торговые предложения' },
];

const allProductCategories = computed(() => {
    return props.categories.map((category) => ({
        label: category.name,
        value: category.id,
    }));
});

const openModalOfferCreatePopup = () => {
    editingOfferIndex.value = null;
    offerPopupIsOpen.value = true;
    Object.assign(offerForm, createEmptyOffer());
};

const openModalOfferEditPopup = (index: number) => {
    editingOfferIndex.value = index;
    offerPopupIsOpen.value = true;

    const sourceOffer = productOffers.value[index];

    Object.assign(offerForm, createEmptyOffer());

    const rawOffer = toRaw(sourceOffer);
    offerForm.id = rawOffer.id;
    offerForm.active = rawOffer.active;
    offerForm.sku = rawOffer.sku;
    offerForm.sort = rawOffer.sort;
    offerForm.description = rawOffer.description;
    offerForm.price = rawOffer.price;

    if (Array.isArray(rawOffer.stocks)) {
        offerForm.stocks = rawOffer.stocks.map((stock: any) => ({
            warehouseId: stock.warehouseId,
            quantity: stock.quantity,
            reserved: stock.reserved,
        }));
    }
};

function saveOffer() {
    if (editingOfferIndex.value !== null) {
        productOffers.value[editingOfferIndex.value] = { ...offerForm };
    } else {
        productOffers.value.push({ ...offerForm });
    }

    offerPopupIsOpen.value = false;
}

const removeOffer = (index: number) => {
    productOffers.value.splice(index, 1);
};

const createProduct = () => {
    const payload = {
        ...productForm,
        offers: [...productOffers.value],
    };
    // TODO: save all images.
    router.post(AdminProduct.store.url(), payload);
};
</script>

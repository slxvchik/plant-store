<template>
    <Popup v-model:open="isOpen" :title="isEditMode ? 'Редактирование ТП' : 'Создание ТП'">
        <OfferForm v-model="offerForm" :warehouses="warehouses" />
        <Button type="button" :text="isEditMode ? 'Сохранить' : 'Создать'" secondary @click="save" />
    </Popup>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import OfferForm from '@/components/pages/admin/products/OfferForm.vue';
import Popup from '@/components/Popup.vue';
import type { OfferFormState } from '@/types/form/product';
import type { Warehouse } from '@/types/warehouse';

const props = defineProps<{ warehouses: Warehouse[] }>();
const offers = defineModel<OfferFormState[]>('offers', { required: true });
const isOpen = ref(false);
const isEditMode = ref(false);
const offerForm = ref<OfferFormState>(createEmptyOffer());

function createEmptyOffer(): OfferFormState {
    return {
        clientKey: crypto.randomUUID(),
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
        formFactor: '',
        size: '',
        age: null,
        sowingDate: '',
        images: [],
        videos: [],
    };
}

function copyOffer(offer: OfferFormState): OfferFormState {
    return {
        ...offer,
        stocks: offer.stocks.map((stock) => ({ ...stock })),
        images: offer.images.map((image) => ({ ...image })),
        videos: offer.videos.map((video) => ({ ...video })),
    };
}

const openCreate = () => {
    isEditMode.value = false;
    offerForm.value = createEmptyOffer();
    isOpen.value = true;
};

const openEdit = (offer: OfferFormState) => {
    isEditMode.value = true;
    offerForm.value = copyOffer(offer);
    isOpen.value = true;
};

const save = () => {
    const index = offers.value.findIndex(
        (offer) => offer.clientKey === offerForm.value.clientKey,
    );
    const savedOffer = copyOffer(offerForm.value);

    if (index === -1) {
        offers.value.push(savedOffer);
    } else {
        offers.value[index] = savedOffer;
    }

    isOpen.value = false;
};

defineExpose({ openCreate, openEdit });
</script>

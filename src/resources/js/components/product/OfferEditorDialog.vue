<template>
    <Popup
        v-model:open="isOpen"
        :title="!disabled && isEditMode ? 'Редактирование ТП' : 'Создание ТП'"
    >
        <OfferForm
            v-model:form="offerForm"
            :disabled="disabled"
            :warehouses="warehouses"
        />
        <Button
            v-if="!disabled"
            :text="isEditMode ? 'Сохранить' : 'Создать'"
            secondary
            type="button"
            @click="save"
        />
    </Popup>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Popup from '@/components/Popup.vue';
import OfferForm from '@/components/product/OfferForm.vue';
import { useFormValidator } from '@/composables/useFormValidator.ts';
import type { OfferFormState } from '@/types/product.ts';
import type { Warehouse } from '@/types/warehouse.ts';
import { validate } from '@/utils/validator.ts';

const props = defineProps<{
    warehouses: Warehouse[];
    disabled?: boolean;
}>();
const offers = defineModel<OfferFormState[]>('offers', { required: true });
const isOpen = ref(false);
const isEditMode = ref(false);
const offerForm = useForm<OfferFormState>(createEmptyOffer());

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
    };
}

function copyOffer(offer: OfferFormState): OfferFormState {
    return {
        ...offer,
        stocks: offer.stocks.map((stock) => ({
            warehouseId: stock.warehouseId,
            quantity: stock.quantity,
            reserved: stock.reserved,
        })),
        images: offer.images.map((image) => ({ ...image })),
    };
}

const openCreate = () => {
    isEditMode.value = false;
    offerForm.reset();
    isOpen.value = true;
};

const openEdit = (offer: OfferFormState) => {
    isEditMode.value = true;
    offerForm.reset();
    Object.assign(offerForm, copyOffer(offer));
    isOpen.value = true;
};

const save = () => {
    if (!validateForm()) {
        return;
    }

    const index = offers.value.findIndex(
        (offer) => offer.clientKey === offerForm.clientKey,
    );
    const savedOffer = copyOffer(offerForm.data());

    if (index === -1) {
        offers.value.push(savedOffer);
    } else {
        offers.value[index] = savedOffer;
    }

    isOpen.value = false;
};

const validator = (field: keyof OfferFormState, value: any): string | null => {
    switch (field) {
        case 'sku':
            return validate(value, 'required');
        case 'price':
            return validate(value, 'number|positive');
        default:
            return null;
    }
};

const { validateForm } = useFormValidator(validator, offerForm);

defineExpose({ openCreate, openEdit });
</script>

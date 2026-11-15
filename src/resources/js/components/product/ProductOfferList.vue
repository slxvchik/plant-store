<template>
    <div class="product-offer-list">
        <div class="product-offer-list__header">
            <div>Id</div>
            <div>Активность</div>
            <div>Артикул</div>
            <div>Цена (коп.)</div>
            <div class="product-offer-list__actions-heading">Действие</div>
        </div>
        <div class="product-offer-list__body">
            <div
                v-for="offer in offers"
                :key="offer.clientKey"
                class="product-offer-list__row"
            >
                <div class="product-offer-list__id">
                    {{ offer.id || 'Новое' }}
                </div>
                <div class="product-offer-list__active">{{ offer.active }}</div>
                <div>{{ offer.sku }}</div>
                <div>{{ offer.price }}</div>
                <div class="product-offer-list__actions">
                    <Button
                        :text="disabled ? 'Смотреть' : 'Редактировать'"
                        style-type="link"
                        @click="emit('edit', offer)"
                    />
                    <Button
                        v-if="!disabled"
                        danger
                        style-type="link"
                        text="Удалить"
                        @click="emit('remove', offer.clientKey)"
                    />
                </div>
            </div>
            <div v-if="offers.length === 0" class="product-offer-list__empty">
                Торговые предложения еще не добавлены
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Button from '@/components/Button.vue';
import type { OfferFormState } from '@/types/product.ts';

defineProps<{ offers: OfferFormState[]; disabled?: boolean }>();
const emit = defineEmits<{
    edit: [offer: OfferFormState];
    remove: [clientKey: string];
}>();
</script>

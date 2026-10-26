<template>
    <div class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="grid grid-cols-[80px_120px_1fr_350px_200px] border-b border-gray-200 bg-slate-50 font-medium text-gray-700">
            <div class="border-r border-gray-200 p-3">Id</div>
            <div class="border-r border-gray-200 p-3">Активность</div>
            <div class="border-r border-gray-200 p-3">Артикул</div>
            <div class="border-r border-gray-200 p-3">Цена (коп.)</div>
            <div class="p-3 text-center">Действие</div>
        </div>
        <div class="divide-y divide-gray-200">
            <div
                v-for="offer in offers"
                :key="offer.clientKey"
                class="grid grid-cols-[80px_120px_1fr_350px_200px] items-center text-sm text-gray-700 hover:bg-slate-50"
            >
                <div class="border-r border-gray-200 p-3 text-gray-400">{{ offer.id || 'Новое' }}</div>
                <div class="flex justify-center border-r border-gray-200 p-3">{{ offer.active }}</div>
                <div class="border-r border-gray-200 p-2">{{ offer.sku }}</div>
                <div class="border-r border-gray-200 p-2">{{ offer.price }}</div>
                <div class="flex flex-col p-3 text-center">
                    <Button
                        style-type="link"
                        text="Редактировать"
                        class="cursor-pointer text-yellow-400 hover:text-yellow-600"
                        @click="emit('edit', offer)"
                    />
                    <Button
                        style-type="link"
                        text="Удалить"
                        class="cursor-pointer text-red-400 hover:text-red-600"
                        @click="emit('remove', offer.clientKey)"
                    />
                </div>
            </div>
            <div v-if="offers.length === 0" class="bg-gray-50 p-8 text-center text-gray-400">
                Торговые предложения еще не добавлены
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/Button.vue';
import type { OfferFormState } from '@/types/form/product';

defineProps<{ offers: OfferFormState[] }>();
const emit = defineEmits<{
    edit: [offer: OfferFormState];
    remove: [clientKey: string];
}>();
</script>

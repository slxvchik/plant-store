<template>
    <div class="catalog-filters">
        <fieldset>
            <legend class="catalog-filters__legend">Категория</legend>
            <div class="catalog-filters__categories">
                <label
                    v-for="category in categories"
                    :key="category"
                    class="catalog-filters__category"
                >
                    <input
                        :id="`${idPrefix}-category-${category}`"
                        v-model="selectedCategories"
                        :value="category"
                        class="catalog-filters__checkbox"
                        type="checkbox"
                    />
                    <span class="catalog-filters__check">
                        <span
                            v-if="selectedCategories.includes(category)"
                            class="catalog-filters__check-icon"
                        >
                            <Icon name="check" />
                        </span>
                    </span>
                    {{ category }}
                </label>
            </div>
        </fieldset>
        <div class="catalog-filters__price">
            <div class="catalog-filters__price-header">
                <p class="catalog-filters__legend">Цена от - до</p>
                <p class="catalog-filters__price-value">
                    {{ minPrice }} - {{ maxPrice }}
                </p>
            </div>
            <div class="catalog-filters__range">
                <div class="catalog-filters__range-track" />
                <div class="catalog-filters__range-fill" :style="rangeStyle" />
                <input
                    :id="`${idPrefix}-price-min`"
                    v-model.number="minPrice"
                    class="catalog-filters__range-input"
                    :min="minPriceBase"
                    :max="maxPriceBase"
                    step="1"
                    type="range"
                />
                <input
                    :id="`${idPrefix}-price-max`"
                    v-model.number="maxPrice"
                    class="catalog-filters__range-input"
                    :min="minPriceBase"
                    :max="maxPriceBase"
                    step="1"
                    type="range"
                />
            </div>
            <div class="catalog-filters__range-labels">
                <span>{{ minPriceBase }} ₽</span>
                <span>{{ maxPriceBase }} ₽</span>
            </div>
        </div>
        <label class="catalog-filters__stock">
            Только в наличии
            <input
                v-model="onlyInStock"
                class="catalog-filters__stock-input"
                type="checkbox"
            />
            <span class="catalog-filters__switch" />
        </label>
        <Button
            style-type="link"
            class="catalog-filters__reset"
            type="button"
            @click="$emit('reset')"
        >
            Сбросить всё
        </Button>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';

interface Props {
    idPrefix: string;
    minPriceBase: number;
    maxPriceBase: number;
}
const props = defineProps<Props>();
defineEmits<{ reset: [] }>();
const selectedCategories = defineModel<string[]>('categories', {
    required: true,
});
const rangeStyle = computed(() => {
    const total = props.maxPriceBase - props.minPriceBase;

    if (total <= 0) {
        return { left: '0%', width: '0%' };
    }

    const left = ((minPrice.value - props.minPriceBase) / total) * 100;
    const width = ((maxPrice.value - minPrice.value) / total) * 100;

    return {
        left: `${Math.max(0, Math.min(100, left))}%`,
        width: `${Math.max(0, Math.min(100, width))}%`,
    };
});
const minPrice = defineModel<number>('minPrice', { required: true });
const maxPrice = defineModel<number>('maxPrice', { required: true });
const onlyInStock = defineModel<boolean>('inStock', { required: true });
const categories = [
    'Комнатные растения',
    'Декоративно-лиственные',
    'Деревья',
    'Ампельные растения',
];
</script>
<style lang="scss" scoped>

</style>

<template>
    <div class="catalog-filters">
        <fieldset v-if="allCategories.length > 0">
            <legend class="catalog-filters__legend">Категория</legend>
            <div class="catalog-filters__categories">
                <label
                    v-for="category in allCategories"
                    :key="category.alias"
                    class="catalog-filters__category"
                >
                    <Checkbox
                        :id="`category_checkbox_${category.alias}`"
                        :text="category.name"
                        :model-value="selectedCategories.includes(category.alias)"
                        @update:model-value="(val) => toggleCategory(category.alias, val)"
                        variant="default"
                    />
                </label>
            </div>
        </fieldset>
        <div v-if="props.minPriceBase > 0 && props.minPriceBase < props.maxPriceBase" class="catalog-filters__price">
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
import Checkbox from '@/components/Checkbox.vue';
import type { CategorySearchModel } from '@/types/catalog.ts';

interface Props {
    idPrefix: string;
    allCategories: CategorySearchModel[];
    minPriceBase: number;
    maxPriceBase: number;
}

const props = defineProps<Props>();
defineEmits<{ reset: [] }>();
const selectedCategories = defineModel<string[]>('selectedCategories', { default: () => [] });
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

const toggleCategory = (alias: string, isChecked: boolean) => {
    if (isChecked) {
        if (!selectedCategories.value.includes(alias)) {
            selectedCategories.value.push(alias);
        }
    } else {
        selectedCategories.value = selectedCategories.value.filter(
            (item) => item !== alias
        );
    }
};
</script>

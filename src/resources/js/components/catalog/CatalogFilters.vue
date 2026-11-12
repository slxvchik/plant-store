<template>
    <div class="space-y-7">
        <fieldset>
            <legend class="font-serif text-xl text-text-title dark:text-linen">
                Категория
            </legend>
            <div class="mt-3 space-y-0.5">
                <label
                    v-for="category in categories"
                    :key="category"
                    class="group flex min-h-11 cursor-pointer items-center gap-3 rounded-lg px-1 text-sm text-text-muted transition-colors duration-300 hover:text-primary dark:text-white/60 dark:hover:text-secondary"
                >
                    <input
                        :id="`${idPrefix}-category-${category}`"
                        v-model="selectedCategories"
                        :value="category"
                        class="peer sr-only"
                        type="checkbox"
                    />
                    <span
                        class="flex h-5 w-5 items-center justify-center rounded-md border border-text-title/20 bg-transparent transition-all duration-300 peer-checked:border-primary peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-primary/30 dark:border-white/25"
                    >
                        <span
                            v-if="selectedCategories.includes(category)"
                            class="h-3 w-3 text-white"
                        >
                            <AppIcon name="check" />
                        </span>
                    </span>
                    {{ category }}
                </label>
            </div>
        </fieldset>
        <div class="border-t border-text-title/10 pt-6 dark:border-white/10">
            <div class="flex items-center justify-between gap-3">
                <p class="font-serif text-xl text-text-title dark:text-linen">
                    Цена от - до
                </p>
                <p
                    class="text-sm font-semibold text-primary dark:text-secondary"
                >
                    {{ minPrice }} - {{ maxPrice }}
                </p>
            </div>
            <div
                class="relative mt-5 grid h-11 w-full cursor-pointer accent-primary"
            >
                <div
                    class="absolute top-[50%] left-0 z-0 h-2 w-full -translate-y-[50%] rounded bg-bg-surface"
                />
                <div
                    class="absolute top-[50%] h-2 -translate-y-[50%] rounded bg-primary"
                    :style="rangeStyle"
                />
                <input
                    :id="`${idPrefix}-price-min`"
                    v-model.number="minPrice"
                    class="pointer-events-none z-1 col-start-1 row-start-1 w-full cursor-pointer appearance-none bg-transparent [&::-moz-range-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:pointer-events-auto"
                    :min="minPriceBase"
                    :max="maxPriceBase"
                    step="1"
                    type="range"
                />
                <input
                    :id="`${idPrefix}-price-max`"
                    v-model.number="maxPrice"
                    class="pointer-events-none z-1 col-start-1 row-start-1 w-full cursor-pointer appearance-none bg-transparent [&::-moz-range-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:pointer-events-auto"
                    :min="minPriceBase"
                    :max="maxPriceBase"
                    step="1"
                    type="range"
                />
            </div>
            <div
                class="flex justify-between text-xs text-text-muted dark:text-white/40"
            >
                <span>{{ minPriceBase }} ₽</span>
                <span>{{ maxPriceBase }} ₽</span>
            </div>
        </div>
        <label
            class="flex min-h-12 cursor-pointer items-center justify-between gap-4 border-t border-text-title/10 pt-5 text-sm text-text-title dark:border-white/10 dark:text-linen"
        >
            Только в наличии
            <input v-model="onlyInStock" class="peer sr-only" type="checkbox" />
            <span
                class="relative h-7 w-12 rounded-full bg-text-title/15 transition-all duration-300 peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-primary/30 after:absolute after:top-1 after:left-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-sm after:transition-transform after:duration-300 peer-checked:after:translate-x-5 dark:bg-white/15"
            />
        </label>
        <button
            class="flex min-h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-full border border-text-title/10 text-sm font-medium text-text-muted transition-all duration-300 hover:border-accent hover:text-accent dark:border-white/15 dark:text-white/55"
            type="button"
            @click="$emit('reset')"
        >
            Сбросить всё
        </button>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import AppIcon from '@/components/AppIcon.vue';

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

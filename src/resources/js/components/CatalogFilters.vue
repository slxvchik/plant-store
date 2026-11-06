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
                        type="checkbox"
                        :value="category"
                        class="peer sr-only"
                    />
                    <span
                        class="flex h-5 w-5 items-center justify-center rounded-md border border-text-title/20 bg-transparent transition-all duration-300 peer-checked:border-primary peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-primary/30 dark:border-white/25"
                        ><span
                            v-if="selectedCategories.includes(category)"
                            class="h-3 w-3 text-white"
                            ><AppIcon name="check" /></span
                    ></span>
                    {{ category }}
                </label>
            </div>
        </fieldset>
        <fieldset
            class="border-t border-text-title/10 pt-6 dark:border-white/10"
        >
            <legend
                class="pt-6 font-serif text-xl text-text-title dark:text-linen"
            >
                Освещение
            </legend>
            <div class="mt-3 flex flex-wrap gap-2">
                <label
                    v-for="light in lightOptions"
                    :key="light"
                    class="cursor-pointer"
                >
                    <input
                        v-model="selectedLight"
                        type="checkbox"
                        :value="light"
                        class="peer sr-only"
                    />
                    <span
                        class="flex min-h-11 items-center rounded-full border border-text-title/10 px-3.5 text-xs font-medium text-text-muted transition-all duration-300 peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-primary/30 dark:border-white/15 dark:text-white/55 dark:peer-checked:text-white"
                        >{{ light }}</span
                    >
                </label>
            </div>
        </fieldset>
        <div class="border-t border-text-title/10 pt-6 dark:border-white/10">
            <div class="flex items-center justify-between gap-3">
                <label
                    :for="`${idPrefix}-price`"
                    class="font-serif text-xl text-text-title dark:text-linen"
                    >Цена до</label
                ><span
                    class="text-sm font-semibold text-primary dark:text-secondary"
                    >{{ formatPrice(maxPrice) }}</span
                >
            </div>
            <input
                :id="`${idPrefix}-price`"
                v-model.number="maxPrice"
                type="range"
                min="1500"
                max="7000"
                step="500"
                class="mt-5 h-11 w-full cursor-pointer accent-primary"
            />
            <div
                class="flex justify-between text-xs text-text-muted dark:text-white/40"
            >
                <span>1 500 ₽</span><span>7 000 ₽</span>
            </div>
        </div>
        <label
            class="flex min-h-12 cursor-pointer items-center justify-between gap-4 border-t border-text-title/10 pt-5 text-sm text-text-title dark:border-white/10 dark:text-linen"
        >
            Только в наличии
            <input v-model="onlyInStock" type="checkbox" class="peer sr-only" />
            <span
                class="relative h-7 w-12 rounded-full bg-text-title/15 transition-all duration-300 peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-primary/30 after:absolute after:top-1 after:left-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-sm after:transition-transform after:duration-300 peer-checked:after:translate-x-5 dark:bg-white/15"
            />
        </label>
        <button
            type="button"
            class="flex min-h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-full border border-text-title/10 text-sm font-medium text-text-muted transition-all duration-300 hover:border-accent hover:text-accent dark:border-white/15 dark:text-white/55"
            @click="$emit('reset')"
        >
            Сбросить всё
        </button>
    </div>
</template>

<script setup lang="ts">
import AppIcon from '@/components/AppIcon.vue';
import { useCartDrawer } from '@/composables/useCartDrawer';

defineProps<{ idPrefix: string }>();
defineEmits<{ reset: [] }>();
const selectedCategories = defineModel<string[]>('categories', {
    required: true,
});
const selectedLight = defineModel<string[]>('lights', { required: true });
const maxPrice = defineModel<number>('maxPrice', { required: true });
const onlyInStock = defineModel<boolean>('inStock', { required: true });
const { formatPrice } = useCartDrawer();
const categories = [
    'Комнатные растения',
    'Декоративно-лиственные',
    'Деревья',
    'Ампельные растения',
];
const lightOptions = ['Тень', 'Полутень', 'Яркий свет'];
</script>

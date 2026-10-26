<template>
    <div class="relative w-full">
        <div v-if="label" class="mb-1.5 text-text-muted select-none">{{ label }}</div>
        <div
            class="flex h-11 cursor-pointer items-center justify-between border border-text-muted bg-white px-4 py-3.5 select-none"
            :class="isOpen ? 'rounded-t-lg border-b-transparent' : 'rounded-lg'"
            @click.prevent="isOpen = !isOpen"
        >
            <p class="relative top-px truncate font-sans text-slate-700">{{ displayValue }}</p>
            <span class="flex h-5 w-2.75 cursor-pointer items-center justify-between transition-transform duration-300" :class="isOpen ? 'rotate-270' : 'rotate-90'">
                <ChevronIcon />
            </span>
        </div>
        <div class="absolute top-[calc(100%-1px)] left-0 z-50 w-full overflow-hidden rounded-b-lg border border-text-muted bg-white shadow-lg" :class="isOpen ? 'block' : 'hidden'">
            <ul class="flex max-h-60 flex-1 flex-col overflow-y-auto">
                <li
                    v-for="item in items"
                    :key="item.value"
                    class="cursor-pointer px-4 py-2 text-sm font-semibold transition-colors hover:bg-slate-100"
                    :class="isSelected(item.value) ? 'bg-slate-100 text-secondary' : 'bg-white'"
                    @click="selectItem(item)"
                >
                    {{ item.label }}
                </li>
                <li v-if="items.length === 0" class="cursor-pointer px-4 py-3 text-center text-slate-400">Список пуст</li>
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import ChevronIcon from '@/components/icons/ChevronIcon.vue';
import type { SelectVal } from '@/types/select';

type SelectValue = SelectVal['value'];
type SelectModel = SelectValue | SelectValue[] | null;

interface Props {
    multiple?: boolean;
    items: SelectVal[];
    placeholder?: string;
    label?: string;
    nullable?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    multiple: false,
    placeholder: 'Выберите значение',
    nullable: false,
});
const modelValue = defineModel<SelectModel>({ default: null });
const isOpen = ref(false);

const selectedValues = computed<SelectValue[]>(() =>
    Array.isArray(modelValue.value) ? modelValue.value : [],
);
const isSelected = (value: SelectValue): boolean => {
    if (props.multiple) {
        return selectedValues.value.some((selected) => selected === value);
    }

    return modelValue.value === value;
};
const selectItem = (item: SelectVal): void => {
    if (props.multiple) {
        modelValue.value = isSelected(item.value)
            ? selectedValues.value.filter((value) => value !== item.value)
            : [...selectedValues.value, item.value];

        return;
    }

    modelValue.value = props.nullable && modelValue.value === item.value ? null : item.value;
    isOpen.value = false;
};
const displayValue = computed(() => {
    if (props.multiple) {
        return props.items
            .filter((item) => isSelected(item.value))
            .map((item) => item.label)
            .join(', ') || props.placeholder;
    }

    return props.items.find((item) => item.value === modelValue.value)?.label ?? props.placeholder;
});
</script>

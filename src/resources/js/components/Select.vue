<template>
    <div class="relative w-full">
        <div v-if="label" class="mb-1.5 text-text-muted select-none">
            {{ label }}
        </div>

        <div
            class="flex h-11 cursor-pointer items-center justify-between border border-text-muted bg-white px-4 py-3.5 select-none"
            :class="isOpen ? 'rounded-t-lg border-b-transparent' : 'rounded-lg'"
            @click.prevent="isOpen = !isOpen"
        >
            <p class="relative top-px truncate font-sans text-slate-700">
                {{ displayValue }}
            </p>
            <span
                class="flex h-5 w-2.75 items-center justify-center transition-transform duration-300"
                :class="isOpen ? 'rotate-270' : 'rotate-90'"
            >
                <ChevronIcon />
            </span>
        </div>

        <div
            class="absolute top-[calc(100%-1px)] left-0 z-50 w-full overflow-hidden rounded-b-lg border border-text-muted bg-white shadow-lg"
            :class="isOpen ? 'block' : 'hidden'"
        >
            <ul class="flex max-h-60 flex-1 flex-col overflow-y-auto">
                <li
                    v-for="item in items"
                    :key="item.value"
                    class="cursor-pointer px-4 py-2 text-sm font-semibold transition-colors hover:bg-slate-100"
                    :class="[
                        isSelected(item.value)
                            ? 'bg-slate-100 text-secondary'
                            : 'bg-white',
                    ]"
                    @click="selectItem(item)"
                >
                    {{ item.label }}
                </li>
                <li
                    v-if="items.length === 0"
                    class="px-4 py-3 text-center text-sm text-slate-400"
                >
                    Список пуст
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import ChevronIcon from '@/components/icons/ChevronIcon.vue';
import { SelectVal } from '@/types/select.ts';

interface Props {
    multiple?: boolean;
    items: SelectVal[];
    placeholder?: string;
    label?: string;
    nullable?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    multiple: false,
    items: () => [],
    placeholder: 'Выберите значение',
});

const isOpen = ref(false);

const modelValue = defineModel<any>({ default: null });

const isSelected = (value: string | number) => {
    if (props.multiple) {
        return (
            Array.isArray(modelValue.value) && modelValue.value.includes(value)
        );
    }

    return modelValue.value === value;
};

const selectItem = (item: SelectVal) => {
    if (props.multiple) {
        if (!Array.isArray(modelValue.value)) {
            modelValue.value = [];
        }

        if (modelValue.value.includes(item.value)) {
            modelValue.value = modelValue.value.filter(
                (v: any) => v !== item.value,
            );
        } else {
            modelValue.value = [...modelValue.value, item.value];
        }
    } else {
        if (props.nullable && modelValue.value === item.value) {
            modelValue.value = null;
        } else {
            modelValue.value = item.value;
        }

        isOpen.value = false;
    }
};

const displayValue = computed(() => {
    if (
        props.multiple &&
        Array.isArray(modelValue.value) &&
        modelValue.value.length > 0
    ) {
        return props.items
            .filter((item) => modelValue.value.includes(item.value))
            .map((item) => item.label)
            .join(', ');
    }

    if (
        !props.multiple &&
        modelValue.value !== null &&
        modelValue.value !== undefined
    ) {
        const selected = props.items.find(
            (item) => item.value === modelValue.value,
        );

        return selected ? selected.label : props.placeholder;
    }

    return props.placeholder;
});
</script>

<template>
    <label v-if="variant === 'standard'" class="block">
        <span v-if="label" class="mb-2 block text-sm font-medium text-slate-700">
            {{ label }}
            <span v-if="required" class="text-rose-500">*</span>
        </span>
        <select
            :id="inputId"
            v-model="modelValue"
            :aria-describedby="error || hint ? `${inputId}-message` : undefined"
            :aria-invalid="Boolean(error)"
            :class="fieldClasses"
            :disabled="disabled"
            :multiple="multiple"
            :required="required"
        >
            <option v-if="!multiple" :value="null">{{ placeholder }}</option>
            <option v-for="item in items" :key="item.value" :value="item.value">
                {{ item.label }}
            </option>
        </select>
        <span
            v-if="error"
            :id="`${inputId}-message`"
            class="mt-1.5 block text-xs font-medium text-rose-600"
        >
            {{ error }}
        </span>
        <span
            v-else-if="hint"
            :id="`${inputId}-message`"
            class="mt-1.5 block text-xs text-slate-400"
        >
            {{ hint }}
        </span>
    </label>
    <div
        v-else
        v-click-outside="() => (isOpen = false)"
        class="relative h-full w-full"
    >
        <span
            v-if="label"
            :class="!error ? 'text-text-muted dark:text-white/40' : 'text-red-400'"
            class="mb-1.5 select-none"
        >
            {{ label }}
            <span v-if="required" class="text-red-400">*</span>
        </span>
        <div
            :class="[
                isOpen
                    ? 'rounded-t-2xl !border-primary border-b-transparent ring-4 ring-primary/10'
                    : 'rounded-2xl',
                !error
                    ? 'border-text-title/15 focus:border-primary focus:ring-4 focus:ring-primary/10 dark:border-white/15'
                    : 'border-red-500 focus:ring-4 focus:ring-red-500/10',
            ]"
            class="flex h-12 cursor-pointer items-center justify-between border bg-bg-elevated px-4 py-3.5 focus:outline-none dark:bg-bg-night-soft"
            tabindex="0"
            @click.prevent="toggleDropdown"
            @keydown.space.prevent="toggleDropdown"
            @keydown.enter.prevent="toggleDropdown"
            @keydown.esc="isOpen = false"
        >
            <p class="relative top-px truncate font-sans text-text-title dark:text-white">
                {{ displayValue }}
            </p>
            <span
                :class="isOpen ? 'rotate-270' : 'rotate-90'"
                class="flex h-5 w-5 cursor-pointer items-center justify-between transition-transform duration-300"
            >
                <AppIcon name="chevron" />
            </span>
        </div>
        <p v-if="error" class="text-red-400">{{ error }}</p>
        <p v-else-if="hint" class="mt-1.5 text-xs text-text-muted">{{ hint }}</p>
        <div
            :class="[isOpen ? 'block' : 'hidden']"
            class="absolute top-[calc(100%+5px)] left-0 z-50 w-full overflow-hidden rounded-b-2xl shadow-lg"
        >
            <ul class="flex max-h-60 flex-1 flex-col overflow-y-auto">
                <li
                    v-for="(item, index) in items"
                    :key="item.value"
                    ref="itemRefs"
                    :class="
                        isSelected(item.value)
                            ? 'bg-slate-200 dark:text-secondary'
                            : 'bg-bg-elevated dark:bg-bg-night-soft dark:text-white'
                    "
                    class="cursor-pointer px-4 py-2 text-sm font-semibold text-text-title transition-colors outline-none hover:bg-slate-100 focus:bg-slate-300 dark:focus:text-secondary"
                    tabindex="-1"
                    @click="selectItem(item)"
                    @keydown.space.prevent="selectItem(item)"
                    @keydown.enter.prevent="selectItem(item)"
                    @keydown.esc="isOpen = false"
                    @keydown.down.prevent="moveFocus(index, 1)"
                    @keydown.up.prevent="moveFocus(index, -1)"
                >
                    {{ item.label }}
                </li>
                <li
                    v-if="items.length === 0"
                    class="cursor-pointer px-4 py-3 text-center text-slate-400"
                >
                    Список пуст
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { computed, nextTick, ref, useId } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import { clickOutside as vClickOutside } from '@/directives/clickOutside';
import type { SelectItem } from '@/types/select-item.ts';

type SelectValue = SelectItem['value'];
type SelectModel = SelectValue | SelectValue[] | null;

interface Props {
    id?: string;
    multiple?: boolean;
    items: SelectItem[];
    placeholder?: string;
    label?: string;
    nullable?: boolean;
    error?: string;
    disabled?: boolean;
    required?: boolean;
    hint?: string;
    variant?: 'dropdown' | 'standard';
}

const props = withDefaults(defineProps<Props>(), {
    multiple: false,
    placeholder: 'Выберите значение',
    nullable: false,
    variant: 'standard',
});

const modelValue = defineModel<SelectModel>({ default: null });
const generatedId = useId();
const inputId = computed(() => props.id ?? `select-${generatedId}`);
const itemRefs = ref<HTMLLIElement[]>([]);
const isOpen = ref(false);
const selectedValues = computed<SelectValue[]>(() =>
    Array.isArray(modelValue.value) ? modelValue.value : [],
);
const fieldClasses = computed(() => [
    'w-full cursor-pointer rounded-xl border bg-white px-3.5 text-sm text-slate-900 shadow-sm outline-none transition focus:ring-4 disabled:cursor-not-allowed disabled:bg-slate-50',
    props.multiple ? 'min-h-11 py-2' : 'h-11',
    props.error
        ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-100'
        : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-100',
]);

const moveFocus = (currentIndex: number, step: number) => {
    const count = props.items.length;

    if (!count) {
        return;
    }

    const nextIndex = (currentIndex + step + count) % count;
    const nextElement = itemRefs.value[nextIndex];

    if (nextElement) {
        nextElement.focus();
        nextElement.scrollIntoView({ block: 'nearest' });
    }
};

const toggleDropdown = async () => {
    if (props.disabled) {
        return;
    }

    isOpen.value = !isOpen.value;
    await nextTick();

    if (isOpen.value) {
        const selectedIndex = props.items.findIndex((item) =>
            props.multiple
                ? selectedValues.value.includes(item.value)
                : modelValue.value === item.value,
        );
        const targetIndex = selectedIndex >= 0 ? selectedIndex : 0;
        itemRefs.value[targetIndex]?.focus();
    }
};

const isSelected = (value: SelectValue): boolean => {
    if (props.multiple) {
        return selectedValues.value.some((selected) => selected === value);
    }

    return modelValue.value === value;
};

const selectItem = (item: SelectItem): void => {
    if (props.disabled) {
        return;
    }

    if (props.multiple) {
        modelValue.value = isSelected(item.value)
            ? selectedValues.value.filter((value) => value !== item.value)
            : [...selectedValues.value, item.value];

        return;
    }

    modelValue.value =
        props.nullable && modelValue.value === item.value ? null : item.value;
    isOpen.value = false;
};

const displayValue = computed(() => {
    if (props.multiple) {
        return (
            props.items
                .filter((item) => isSelected(item.value))
                .map((item) => item.label)
                .join(', ') || props.placeholder
        );
    }

    return (
        props.items.find((item) => item.value === modelValue.value)?.label ??
        props.placeholder
    );
});
</script>

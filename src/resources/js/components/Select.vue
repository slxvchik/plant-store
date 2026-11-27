<template>
    <div
        :class="[
            'select',
            { 'select--error': error },
            { 'select--disabled': disabled },
        ]"
        v-click-outside="() => closePopup(false)"
    >
        <p
            v-if="label"
            class="select__label"
            @click="activatePopup"
        >
            {{ label }}
            <span v-if="required" class="select__required">*</span>
        </p>
        <div
            class="select__field"
            :class="{'select__field--open': showPopup}"
            :aria-describedby="messageId"
            :aria-invalid="Boolean(error)"
            :tabindex="disabled ? -1 : 0"
            ref="selectRef"
            @click="activatePopup"
            @keydown="keydown"
            @focusout="onFocusOut"
        >
            <div
                v-show="!showPopup || !searchable"
                class="select__text"
            >
                {{ displayValue }}
            </div>
            <input
                v-if="searchable"
                v-show="showPopup"
                :id="queryId"
                ref="searchRef"
                v-model="searchInput"
                placeholder="Поиск"
                class="select__search"
                @click.stop
            >
            <ul
                class="select__options"
                v-show="showPopup"
                ref="optionsListRef"
                @mousedown.prevent
                @click.stop
            >
                <template v-if="displayItems.length > 0">
                    <li
                        v-for="(item, index) in displayItems"
                        :key="item.value"
                        class="select__option"
                        :class="[
                            { 'select__option--active': isSelected(item) },
                            { 'select__option--hover': index === hoverIndex },
                        ]"
                        @mouseenter="hoverIndex = index"
                        @click.stop="itemToggle(item)"
                    >
                        {{ item.label }}
                    </li>
                </template>
                <li
                    v-else
                    class="select__option-empty"
                >
                    Ничего не найдено
                </li>
            </ul>
        </div>
        <span v-if="error" :id="messageId" class="select__error">
            {{ error }}
        </span>
        <span v-else-if="hint" :id="messageId" class="select__hint">
            {{ hint }}
        </span>
    </div>
</template>

<script lang="ts" setup>
import { computed, nextTick, ref, useId, watch } from 'vue';
import { clickOutside as vClickOutside } from '@/directives/clickOutside';
import type { SelectItem } from '@/types/select-item';

type SelectValue = SelectItem['value'];
const props = withDefaults(
    defineProps<{
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
        variant?: 'standard';
        searchable?: boolean;
    }>(),
    { placeholder: 'Выберите значение', variant: 'standard', searchable: false },
);
const modelValue = defineModel<SelectValue | SelectValue[] | null>({
    default: null,
});

const searchInput = ref('');
const generatedId = useId();
const inputId = computed(() => props.id ?? `select-${generatedId}`);
const messageId = computed(() =>
    props.error || props.hint ? `${inputId.value}-message` : undefined,
);
const queryId = computed(() => `${inputId.value}-query`);

const showPopup = ref(false);
const hoverIndex = ref(-1);

const selectRef = ref<HTMLDivElement | null>(null);
const searchRef = ref<HTMLInputElement | null>(null);
const optionsListRef = ref<HTMLUListElement | null>(null);

const displayItems = computed(() => {
    const query = searchInput.value.trim().toLowerCase();

    if (!query) {
        return props.items;
    }

    return props.items.filter((item) =>
        String(item.label ?? '').toLowerCase().includes(query)
    );
});

watch(displayItems, (items) => {
    hoverIndex.value = items.length > 0 ? 0 : -1;
});

const scrollToHovered = () => {
    nextTick(() => {
        const list = optionsListRef.value;
        const activeEl = list?.children[hoverIndex.value] as HTMLElement | undefined;

        if (list && activeEl) {
            activeEl.scrollIntoView({ block: 'nearest' });
        }
    });
};

const activatePopup = async () => {
    if (props.disabled) {
        return;
    }

    showPopup.value = true;

    const selectedIdx = displayItems.value.findIndex((item) => isSelected(item));
    hoverIndex.value = selectedIdx >= 0 ? selectedIdx : (displayItems.value.length > 0 ? 0 : -1);

    await nextTick();

    if (props.searchable) {
        searchRef.value?.focus();
    } else {
        selectRef.value?.focus();
    }

    scrollToHovered();
};

const closePopup = (returnFocus = false) => {
    showPopup.value = false;
    searchInput.value = '';
    hoverIndex.value = -1;

    if (returnFocus) {
        selectRef.value?.focus();
    }
};

const displayValue = computed(() => {
    const val = modelValue.value;
    const defaultPlaceholder = props.placeholder ?? (props.multiple ? 'Выберите значения' : 'Выберите значение');

    if (val == null || (typeof val === 'string' && val.trim() === '')) {
        return defaultPlaceholder;
    }

    if (Array.isArray(val)) {
        if (val.length === 0) {
            return defaultPlaceholder;
        }

        const labels = val.map((v) => props.items.find((si) => si.value === v)?.label ?? v);

        if (labels.length <= 3) {
            return labels.join(', ');
        }

        const visibleItems = labels.slice(0, 3).join(', ');
        const remainingCount = labels.length - 3;

        return `${visibleItems} +${remainingCount}`;
    }

    return props.items.find((si) => si.value === val)?.label;
});

const itemToggle = (selectItem: SelectItem) => {
    const targetValue = selectItem.value;

    if (props.multiple) {
        const currentValues = Array.isArray(modelValue.value) ? modelValue.value : [];
        const alreadySelected = currentValues.includes(targetValue);

        modelValue.value = alreadySelected
            ? currentValues.filter((val) => val !== targetValue)
            : [...currentValues, targetValue];

        if (props.searchable) {
            searchRef.value?.focus();
        } else {
            selectRef.value?.focus();
        }

        return;
    }

    if (modelValue.value === targetValue) {
        modelValue.value = props.nullable ? null : targetValue;
    } else {
        modelValue.value = targetValue;
    }

    closePopup(true);
};

const isSelected = (item: SelectItem): boolean => {
    const val = modelValue.value;

    if (val == null) {
        return false;
    }

    return Array.isArray(val)
        ? val.includes(item.value)
        : val === item.value;
};

const keydown = (e: KeyboardEvent) => {
    if (props.disabled) {
        return;
    }

    const isSearchFocused = document.activeElement === searchRef.value;

    if (!showPopup.value) {
        if (['Enter', ' ', 'ArrowDown', 'ArrowUp'].includes(e.key)) {
            e.preventDefault();
            activatePopup();
        }

        return;
    }

    if (isSearchFocused && e.key === ' ') {
        return;
    }

    const itemsCount = displayItems.value.length;

    switch (e.key) {
        case 'ArrowDown':
            e.preventDefault();

            if (itemsCount > 0) {
                hoverIndex.value = (hoverIndex.value + 1) % itemsCount;
                scrollToHovered();
            }

            break;

        case 'ArrowUp':
            e.preventDefault();

            if (itemsCount > 0) {
                hoverIndex.value = (hoverIndex.value - 1 + itemsCount) % itemsCount;
                scrollToHovered();
            }

            break;

        case 'Enter':
        case ' ':
            e.preventDefault();

            if (hoverIndex.value >= 0 && displayItems.value[hoverIndex.value]) {
                itemToggle(displayItems.value[hoverIndex.value]);
            }

            break;

        case 'Escape':
            e.preventDefault();
            closePopup(true);
            break;

        case 'Tab':
            closePopup(false);
            break;
    }
};
const onFocusOut = (e: FocusEvent) => {
    const field = e.currentTarget as HTMLElement | null;
    const nextFocused = e.relatedTarget as Node | null;

    if (field && nextFocused && field.contains(nextFocused)) {
        return;
    }

    closePopup(false);
};
</script>

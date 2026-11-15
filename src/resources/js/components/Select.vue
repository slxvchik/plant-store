<template>
    <label
        :class="['select', `select--${variant}`, { 'select--error': error }]"
    >
        <span v-if="label" class="select__label">
            {{ label }}
            <span v-if="required" class="select__required">*</span>
        </span>
        <select
            :id="inputId"
            v-model="modelValue"
            :aria-describedby="messageId"
            :aria-invalid="Boolean(error)"
            :disabled="disabled"
            :multiple="multiple"
            :required="required"
            class="select__field"
        >
            <option v-if="!multiple" :value="null">{{ placeholder }}</option>
            <option v-for="item in items" :key="item.value" :value="item.value">
                {{ item.label }}
            </option>
        </select>
        <span v-if="error" :id="messageId" class="select__error">
            {{ error }}
        </span>
        <span v-else-if="hint" :id="messageId" class="select__hint">
            {{ hint }}
        </span>
    </label>
</template>

<script lang="ts" setup>
import { computed, useId } from 'vue';
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
        variant?: 'dropdown' | 'standard';
    }>(),
    { placeholder: 'Выберите значение', variant: 'standard' },
);
const modelValue = defineModel<SelectValue | SelectValue[] | null>({
    default: null,
});
const generatedId = useId();
const inputId = computed(() => props.id ?? `select-${generatedId}`);
const messageId = computed(() =>
    props.error || props.hint ? `${inputId.value}-message` : undefined,
);
</script>

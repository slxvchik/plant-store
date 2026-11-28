<template>
    <div :class="['input', `input--${variant}`, { 'input--error': error }]">
        <label
            v-if="label && variant === 'standard'"
            :for="inputId"
            class="input__label"
        >
            {{ label }}
            <span v-if="required" class="input__required">*</span>
        </label>
        <div class="input__wrap">
            <label
                v-if="label && variant === 'floating'"
                :class="[
                    'input__floating-label',
                    { 'input__floating-label--active': floated },
                ]"
                :for="inputId"
            >
                {{ label }}
            </label>
            <input
                :id="inputId"
                v-maska
                :aria-describedby="messageId"
                :aria-invalid="Boolean(error)"
                :autocomplete="autocomplete"
                :data-maska="maska"
                :disabled="disabled"
                :max="max"
                :min="min"
                :placeholder="placeholder"
                :required="required"
                :step="step"
                :type="type"
                :value="modelValue ?? ''"
                class="input__field"
                @blur="focused = false"
                @focus="focused = true"
                @input="updateValue"
            />
        </div>
        <p v-if="error" :id="messageId" class="input__error">{{ error }}</p>
        <p v-else-if="hint" :id="messageId" class="input__hint">{{ hint }}</p>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref, useId } from 'vue';

const props = withDefaults(
    defineProps<{
        id?: string;
        type?:
            | 'text'
            | 'password'
            | 'email'
            | 'number'
            | 'date'
            | 'tel'
            | 'search';
        label?: string;
        error?: string;
        disabled?: boolean;
        autocomplete?: string;
        placeholder?: string;
        hint?: string;
        required?: boolean;
        min?: number;
        max?: number;
        step?: number;
        variant?: 'floating' | 'standard';
    }>(),
    {
        type: 'text',
        autocomplete: 'off',
        placeholder: '',
        hint: '',
        variant: 'standard',
    },
);
const modelValue = defineModel<string | number | null>({ default: '' });
const focused = ref(false);
const generatedId = useId();
const inputId = computed(() => props.id ?? `input-${generatedId}`);
const messageId = computed(() =>
    props.error || props.hint ? `${inputId.value}-message` : undefined,
);
const maska = computed(() =>
    props.type === 'tel' ? '+7 (###) ###-##-##' : null,
);
const floated = computed(
    () =>
        focused.value ||
        String(modelValue.value ?? '').length > 0 ||
        props.type === 'date',
);
const updateValue = (event: Event) => {
    const value = (event.target as HTMLInputElement).value;
    modelValue.value =
        props.type === 'number' ? (value === '' ? null : Number(value)) : value;
};
</script>

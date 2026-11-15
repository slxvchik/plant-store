<template>
    <div
        :class="[
            'textarea',
            `textarea--${variant}`,
            { 'textarea--error': error },
        ]"
    >
        <label
            v-if="label && variant === 'standard'"
            :for="inputId"
            class="textarea__label"
        >
            {{ label }}
            <span v-if="required" class="textarea__required">*</span>
        </label>
        <div class="textarea__wrap">
            <label
                v-if="label && variant === 'floating'"
                :class="[
                    'textarea__floating-label',
                    { 'textarea__floating-label--active': floated },
                ]"
                :for="inputId"
            >
                {{ label }}
            </label>
            <textarea
                :id="inputId"
                v-model="modelValue"
                :aria-describedby="messageId"
                :aria-invalid="Boolean(error)"
                :disabled="disabled"
                :placeholder="placeholder"
                :required="required"
                :rows="rows"
                class="textarea__field"
                @blur="focused = false"
                @focus="focused = true"
            />
        </div>
        <p v-if="error" :id="messageId" class="textarea__error">{{ error }}</p>
        <p v-else-if="hint" :id="messageId" class="textarea__hint">
            {{ hint }}
        </p>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref, useId } from 'vue';

const props = withDefaults(
    defineProps<{
        id?: string;
        label?: string;
        error?: string;
        disabled?: boolean;
        placeholder?: string;
        hint?: string;
        required?: boolean;
        rows?: number;
        variant?: 'floating' | 'standard';
    }>(),
    { placeholder: '', hint: '', rows: 4, variant: 'standard' },
);
const modelValue = defineModel<string | null>({ default: '' });
const focused = ref(false);
const generatedId = useId();
const inputId = computed(() => props.id ?? `textarea-${generatedId}`);
const messageId = computed(() =>
    props.error || props.hint ? `${inputId.value}-message` : undefined,
);
const floated = computed(
    () => focused.value || String(modelValue.value ?? '').length > 0,
);
</script>

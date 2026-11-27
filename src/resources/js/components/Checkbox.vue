<template>
    <div
        :class="[
            'checkbox',
            `checkbox--${variant}`,
            { 'checkbox--error': error },
        ]"
    >
        <label :for="inputId" class="checkbox__label">
            <input
                :id="inputId"
                v-model="modelValue"
                :disabled="disabled"
                class="checkbox__native"
                type="checkbox"
            />
            <span
                :class="[
                    'checkbox__box',
                    { 'checkbox__box--checked': modelValue },
                ]"
            >
                <Icon v-if="variant === 'default' && modelValue" name="check" />
            </span>
            <span class="checkbox__copy">
                <span class="checkbox__text">{{ text }}</span>
                <span v-if="description" class="checkbox__description">
                    {{ description }}
                </span>
            </span>
        </label>
        <p v-if="error" class="checkbox__error">{{ error }}</p>
    </div>
</template>

<script lang="ts" setup>
import { computed, useId } from 'vue';
import Icon from '@/components/icons/Icon.vue';

const props = withDefaults(
    defineProps<{
        id?: string;
        text?: string;
        error?: string;
        disabled?: boolean;
        description?: string;
        variant?: 'default' | 'standard';
    }>(),
    { text: '', description: '', variant: 'standard' },
);
const modelValue = defineModel<boolean>({ default: false });
const generatedId = useId();
const inputId = computed(() => props.id ?? `checkbox-${generatedId}`);
</script>

<template>
    <div v-if="variant === 'standard'" class="flex flex-col">
        <label
            class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 transition hover:border-emerald-200"
            :for="inputId"
        >
            <input
                :id="inputId"
                v-model="modelValue"
                :disabled="disabled"
                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                type="checkbox"
            />
            <span>
                <span class="block text-sm font-medium text-slate-700">{{ text }}</span>
                <span v-if="description" class="mt-0.5 block text-xs leading-5 text-slate-500">
                    {{ description }}
                </span>
            </span>
        </label>
        <p v-if="error" class="mt-1.5 text-xs font-medium text-rose-600">{{ error }}</p>
    </div>
    <div v-else class="flex flex-col">
        <div class="flex cursor-pointer items-center">
            <input
                :id="inputId"
                v-model="modelValue"
                :disabled="disabled"
                class="hidden"
                type="checkbox"
            />
            <label :for="inputId" class="cursor-pointer">
                <span :class="checkboxClassesResult">
                    <svg
                        v-if="modelValue"
                        fill="currentColor"
                        height="12"
                        viewBox="0 0 1920 1920"
                        width="12"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M1743.858 267.012 710.747 1300.124 176.005 765.382 0 941.387l710.747 710.871 1209.24-1209.116z"
                            fill-rule="evenodd"
                        />
                    </svg>
                </span>
                <span
                    :class="!error ? 'text-text-muted' : 'text-red-400'"
                    class="text-heading ms-2 font-medium select-none"
                >
                    {{ text }}
                </span>
            </label>
        </div>
        <p v-if="error" class="text-red-400">{{ error }}</p>
    </div>
</template>

<script lang="ts" setup>
import { computed, useId } from 'vue';

interface Props {
    id?: string;
    text?: string;
    error?: string;
    disabled?: boolean;
    description?: string;
    variant?: 'default' | 'standard';
}

const props = withDefaults(defineProps<Props>(), {
    text: '',
    description: '',
    variant: 'standard',
});

const modelValue = defineModel<boolean>({ default: false });
const generatedId = useId();
const inputId = computed(() => props.id ?? `checkbox-${generatedId}`);
const checkboxClasses =
    'border-default-medium inline-flex h-4 w-4 items-center justify-center rounded-sm border align-middle text-white transition-bg duration-300';
const checkboxClassesResult = computed(() => {
    if (modelValue.value && !props.disabled) {
        return [checkboxClasses, 'bg-secondary border-secondary'].join(' ');
    }

    if (!modelValue.value && !props.disabled) {
        return [checkboxClasses, 'bg-white border-[#DCE3DB]'].join(' ');
    }

    if (props.disabled && modelValue.value) {
        return [checkboxClasses, 'bg-secondary/50 border-secondary/50'].join(' ');
    }

    return [checkboxClasses, 'border-secondary/50'].join(' ');
});
</script>

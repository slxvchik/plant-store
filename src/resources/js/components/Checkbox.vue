<template>
    <div class="flex flex-col">
        <div class="flex cursor-pointer items-center">
            <input
                :id="id"
                v-model="modelValue"
                :disabled="disabled"
                class="hidden"
                type="checkbox"
            />
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
            <label
                :class="!error ? 'text-text-muted' : 'text-red-400'"
                :for="id"
                class="text-heading ms-2 cursor-pointer font-medium select-none"
            >
                {{ text }}
            </label>
        </div>
        <p v-if="error" class="text-red-400">
            {{ error }}
        </p>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';

interface Props {
    id: string;
    text?: string;
    error?: string;
    disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    text: '',
});

const modelValue = defineModel<boolean>({ default: false });

const checkboxClasses =
    'border-default-medium h-4 w-4 rounded-sm border flex items-center justify-center text-white transition-bg duration-300';

const checkboxClassesResult = computed(() => {
    if (modelValue.value && !props.disabled) {
        return [checkboxClasses, 'bg-secondary border-secondary'].join(' ');
    } else if (!modelValue.value && !props.disabled) {
        return [checkboxClasses, 'bg-white border-[#DCE3DB]'].join(' ');
    } else if (props.disabled && modelValue.value) {
        return [checkboxClasses, 'bg-secondary/50 border-secondary/50'].join(
            ' ',
        );
    } else if (props.disabled && !modelValue.value) {
        return [checkboxClasses, 'border-secondary/50'].join(' ');
    }

    return checkboxClasses;
});
</script>

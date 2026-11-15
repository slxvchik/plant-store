<template>
    <div :class="variant === 'standard' ? 'block' : 'flex flex-col'">
        <label
            v-if="variant === 'standard' && label"
            :for="inputId"
            class="mb-2 block text-sm font-medium text-slate-700"
        >
            {{ label }}
            <span v-if="required" class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <div
                v-if="variant === 'floating' && floated && multiline"
                class="pointer-events-none absolute top-px right-px left-px z-10 h-7 rounded-t-[15px] bg-bg-elevated dark:bg-bg-night-soft"
            />
            <label
                v-if="variant === 'floating' && label"
                :class="[
                    multiline ? 'top-5' : 'top-1/2 -translate-y-1/2',
                    floated
                        ? multiline
                            ? '!top-2.5 !text-xs'
                            : '!top-2.5 !translate-y-0 !text-xs'
                        : 'text-sm',
                    focused ? 'text-primary dark:text-secondary' : '',
                    !error
                        ? 'text-text-muted dark:text-white/40'
                        : 'text-red-400',
                ]"
                :for="inputId"
                class="pointer-events-none absolute left-4 z-10 mb-4 origin-left transition-all duration-300 ease-in-out"
            >
                {{ label }}
            </label>
            <textarea
                v-if="multiline"
                :id="inputId"
                :aria-describedby="messageId"
                :aria-invalid="Boolean(error)"
                :class="fieldClasses"
                :disabled="disabled"
                :placeholder="placeholder"
                :required="required"
                :rows="variant === 'standard' ? 4 : 5"
                :value="modelValue ?? ''"
                @blur="focused = false"
                @focus="focused = true"
                @input="updateValue"
            />
            <input
                v-else
                :id="inputId"
                v-maska
                :aria-describedby="messageId"
                :aria-invalid="Boolean(error)"
                :autocomplete="autocomplete"
                :class="fieldClasses"
                :data-maska="maska"
                :disabled="disabled"
                :max="max"
                :min="min"
                :placeholder="placeholder"
                :required="required"
                :step="step"
                :type="type"
                :value="modelValue ?? ''"
                @blur="focused = false"
                @focus="focused = true"
                @input="updateValue"
            />
        </div>
        <div v-if="variant === 'floating'" class="relative">
            <Transition
                enter-active-class="transition-all duration-300"
                enter-from-class="-translate-y-1 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition-all duration-200"
                leave-to-class="opacity-0"
            >
                <p
                    v-if="error"
                    :id="messageId"
                    class="mt-1.5 pl-2 text-xs text-red-600 dark:text-red-400"
                >
                    {{ error }}
                </p>
            </Transition>
        </div>
        <p
            v-else-if="error"
            :id="messageId"
            class="mt-1.5 block text-xs font-medium text-rose-600"
        >
            {{ error }}
        </p>
        <p
            v-else-if="hint"
            :id="messageId"
            class="mt-1.5 block text-xs text-slate-400"
        >
            {{ hint }}
        </p>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref, useId } from 'vue';

interface Props {
    id?: string;
    type?: 'text' | 'password' | 'email' | 'number' | 'date' | 'tel';
    label?: string;
    error?: string;
    disabled?: boolean;
    multiline?: boolean;
    autocomplete?: string;
    placeholder?: string;
    hint?: string;
    required?: boolean;
    min?: number;
    max?: number;
    step?: number;
    variant?: 'floating' | 'standard';
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    autocomplete: 'off',
    placeholder: '',
    hint: '',
    variant: 'standard',
});

const modelValue = defineModel<string | number | null>({ default: '' });
const generatedId = useId();
const inputId = computed(() => props.id ?? `input-${generatedId}`);
const messageId = computed(() =>
    props.error || props.hint ? `${inputId.value}-message` : undefined,
);
const focused = ref(false);
const floated = computed(
    () =>
        focused.value ||
        (typeof modelValue.value === 'string' && modelValue.value.length > 0) ||
        typeof modelValue.value === 'number' ||
        props.type === 'date',
);
const maska = computed(() => (props.type === 'tel' ? '+7 (###) ###-##-##' : null));
const fieldClasses = computed(() => {
    if (props.variant === 'standard') {
        return [
            'w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:ring-4 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400',
            props.error
                ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-100'
                : 'border-slate-200 focus:border-emerald-500 focus:ring-emerald-100',
            props.multiline ? 'min-h-28 resize-y' : 'h-11',
        ];
    }

    return [
        'peer w-full rounded-2xl border bg-bg-elevated px-4 text-[15px] text-text-title transition-all duration-300 focus:outline-none disabled:cursor-not-allowed disabled:opacity-60 dark:bg-bg-night-soft dark:text-white',
        props.error
            ? 'border-red-500 focus:ring-4 focus:ring-red-500/10'
            : 'border-text-title/15 focus:border-primary focus:ring-4 focus:ring-primary/10 dark:border-white/15',
        props.multiline ? 'min-h-32 resize-none pt-6 pb-3' : 'h-12 pt-5 pb-1',
    ];
});

const updateValue = (event: Event) => {
    const value = (event.target as HTMLInputElement | HTMLTextAreaElement).value;
    modelValue.value =
        props.type === 'number' ? (value === '' ? null : Number(value)) : value;
};
</script>

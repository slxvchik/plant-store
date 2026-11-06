<template>
    <div class="flex flex-col">
        <div class="relative">
            <div
                v-if="floated && multiline"
                class="pointer-events-none absolute top-px right-px left-px z-10 h-7 rounded-t-[15px] bg-bg-elevated dark:bg-bg-night"
            ></div>

            <label
                v-if="label"
                :for="id"
                class="pointer-events-none absolute left-4 z-10 mb-4 origin-left transition-all duration-300 ease-in-out"
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
            >
                {{ label }}
            </label>
            <textarea
                v-if="multiline"
                :id="id"
                v-model="modelValue"
                :aria-invalid="Boolean(error)"
                :aria-describedby="error ? `${id}-error` : undefined"
                rows="5"
                class="peer min-h-32 w-full resize-none rounded-2xl border bg-bg-elevated px-4 pt-6 pb-3 text-[15px] text-text-title transition-all duration-300 focus:outline-none dark:bg-bg-night dark:text-white"
                :class="
                    error
                        ? 'border-red-500 focus:ring-4 focus:ring-red-500/10'
                        : 'border-text-title/15 focus:border-primary focus:ring-4 focus:ring-primary/10 dark:border-white/15'
                "
                @focus="focused = true"
                @blur="focused = false"
            />
            <input
                v-else
                :id="id"
                v-model="modelValue"
                :type="type"
                :autocomplete="autocomplete"
                :aria-invalid="Boolean(error)"
                :aria-describedby="error ? `${id}-error` : undefined"
                class="peer h-15 w-full rounded-2xl border bg-bg-elevated px-4 pt-5 pb-1 text-[15px] text-text-title transition-all duration-300 focus:outline-none dark:bg-bg-night dark:text-white"
                :class="
                    error
                        ? 'border-red-500 focus:ring-4 focus:ring-red-500/10'
                        : 'border-text-title/15 focus:border-primary focus:ring-4 focus:ring-primary/10 dark:border-white/15'
                "
                v-maska
                :data-maska="maska"
                :disabled="disabled"
                @focus="focused = true"
                @blur="focused = false"
            />
        </div>
        <div class="relative">
            <Transition
                enter-active-class="transition-all duration-300"
                enter-from-class="-translate-y-1 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition-all duration-200"
                leave-to-class="opacity-0"
            >
                <p
                    v-if="error"
                    :id="`${id}-error`"
                    class="mt-1.5 pl-2 text-xs text-red-600 dark:text-red-400"
                >
                    {{ error }}
                </p>
            </Transition>
        </div>
    </div>
</template>

<script setup lang="ts">
import { vMaska as _vMaska } from 'maska/vue';
import { computed, ref } from 'vue';

interface Props {
    id: string;
    type?: 'text' | 'password' | 'email' | 'number' | 'date' | 'tel';
    label?: string;
    error?: string;
    disabled?: boolean;
    multiline?: boolean;
    autocomplete?: string;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    autocomplete: 'off',
});

const modelValue = defineModel<string | number | null>({ default: '' });
const focused = ref(false);
const floated = computed(
    () =>
        focused.value ||
        (typeof modelValue.value === 'string' && modelValue.value.length > 0) ||
        typeof modelValue.value === 'number' ||
        props.type === 'date',
);
const maska = computed(() => {
    if (props.type === 'tel') {
        return '+7 (###) ###-##-##';
    }

    return null;
});
</script>

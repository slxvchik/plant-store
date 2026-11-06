<template>
    <div>
        <div class="relative">
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
                @focus="focused = true"
                @blur="focused = false"
            />
            <label
                :for="id"
                class="pointer-events-none absolute left-4 origin-left text-text-muted transition-all duration-300 ease-in-out dark:text-white/40"
                :class="[
                    multiline ? 'top-5' : 'top-1/2 -translate-y-1/2',
                    floated
                        ? multiline
                            ? '!top-2.5 !text-xs'
                            : '!top-2.5 !translate-y-0 !text-xs'
                        : 'text-sm',
                    focused ? 'text-primary dark:text-secondary' : '',
                    error ? 'text-red-500' : '',
                ]"
                >{{ label }}</label
            >
        </div>
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
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';

withDefaults(
    defineProps<{
        id: string;
        label: string;
        type?: 'text' | 'email' | 'tel';
        error?: string;
        multiline?: boolean;
        autocomplete?: string;
    }>(),
    { type: 'text', autocomplete: 'off' },
);
const modelValue = defineModel<string>({ default: '' });
const focused = ref(false);
const floated = computed(() => focused.value || modelValue.value.length > 0);
</script>

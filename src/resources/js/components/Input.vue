<template>
    <div class="flex flex-col">
        <label
            v-if="label"
            :for="id"
            class="mb-1.5 select-none"
            :class="!error ? 'text-text-muted' : 'text-red-400'"
        >
            {{ label }}
        </label>
        <input
            :id="id"
            v-model="modelValue"
            :type="type"
            :placeholder="placeholder"
            autocomplete="off"
            class="h-11 rounded-lg border px-4 py-3.5 transition-all duration-300 focus:outline-none"
            :class="
                !error
                    ? 'border-text-muted/50 bg-white text-text-muted placeholder:text-text-muted/50 focus:border-text-muted active:border-text-muted'
                    : 'border-red-400/50 bg-red-400/25 text-red-400 placeholder:text-red-400/50 focus:placeholder:text-red-400/50 active:border-red-400 active:placeholder:text-red-400/50'
            "
            v-maska
            :data-maska="type === 'tel' ? '+7 (###) ###-##-##' : null"
        />
        <p v-if="error" class="text-red-400">
            {{ error }}
        </p>
    </div>
</template>

<script setup lang="ts">
import { vMaska as _vMaska } from 'maska/vue';

interface Props {
    id: string;
    type?: 'text' | 'password' | 'email' | 'number' | 'date' | 'tel';
    placeholder?: string;
    label?: string;
    error?: string;
}

withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
    label: '',
});

const modelValue = defineModel<string | number | null>({ default: '' });
</script>

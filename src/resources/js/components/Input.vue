<template>
    <div class="flex w-full flex-col">
        <label
            v-if="label"
            :for="id"
            class="mb-1.5 select-none"
            :class="!error ? 'text-muted' : 'text-red-400'"
        >
            {{ label }}
        </label>
        <input
            :id="id"
            :type="type"
            v-model="modelValue"
            :placeholder="placeholder"
            class="h-11 rounded-lg border px-4 py-3.5 transition-all duration-300 focus:outline-none"
            :class="
                !error
                    ? 'border-muted/50 bg-white text-muted placeholder:text-muted/50 focus:border-muted focus:placeholder:text-muted active:border-muted active:placeholder:text-muted'
                    : 'border-red-400/50 bg-red-400/25 text-red-400 placeholder:text-red-400/50 focus:border-red-400 focus:placeholder:text-red-400 active:border-red-400 active:placeholder:text-red-400'
            "
        />
        <p v-if="error" class="text-red-400">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
interface Props {
    id: string;
    type?: 'text' | 'password' | 'email' | 'number'; // Строгая типизация типов инпута
    placeholder?: string;
    label?: string;
    error?: string;
}
withDefaults(defineProps<Props>(), {
    type: 'text',
    placeholder: '',
    label: '',
    error: '',
});
const modelValue = defineModel<string>({ default: '' });
</script>

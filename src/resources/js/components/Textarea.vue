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
        <textarea
            :id="id"
            v-model="modelValue"
            :placeholder="placeholder"
            class="rounded-lg border bg-white px-4 py-3.5 focus:outline-none"
            :class="
                !error
                    ? 'border-text-muted/50 bg-white text-text-muted placeholder:text-text-muted/50 focus:border-text-muted active:border-text-muted'
                    : 'border-red-400/50 bg-red-400/25 text-red-400 placeholder:text-red-400/50 focus:border-red-400 focus:placeholder:text-red-400 active:border-red-400 active:placeholder:text-red-400'
            "
        />
        <p v-if="error" class="text-red-400">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
interface Props {
    id: string;
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

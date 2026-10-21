<template>
    <div class="flex w-full flex-col">
        <div class="flex cursor-pointer items-center">
            <input
                :id="id"
                type="checkbox"
                v-model="modelValue"
                class="border-default-medium h-4 w-4 rounded-xs border bg-primary"
            />
            <label
                :for="id"
                class="text-heading ms-2 cursor-pointer font-medium select-none"
            >
                {{ text }}
            </label>
        </div>
        <p v-if="error" class="text-red-400">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
interface Props {
    id: string;
    text?: string;
    error?: string;
}

withDefaults(defineProps<Props>(), {
    text: '',
    error: '',
});

const modelValue = defineModel<boolean>({ default: false });
</script>

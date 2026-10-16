<template>
    <div class="flex w-full flex-col">
        <div class="flex items-center">
            <input :id="id"
                   type="checkbox"
                   v-model="modelValue"
                   class="w-4 h-4 border border-default-medium rounded-xs bg-primary"
            />
            <label :for="id" class="select-none ms-2 font-medium text-heading">{{ text }}</label>
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
    error: ''
});

const modelValue = defineModel<boolean>({ default: false });
</script>

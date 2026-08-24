<template>
    <button :aria-label="text"
        class="flex min-w-24 cursor-pointer items-center justify-center gap-1.5 rounded-full bg-btn-light-bg px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-btn-light-bg-hover">
        {{ text }}
    </button>
</template>

<script setup lang="ts">
defineProps({
    text: {
        type: String,
        required: true
    }
})
</script>

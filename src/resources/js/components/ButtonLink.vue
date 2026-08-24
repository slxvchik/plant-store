<template>
    <a :href="link"
        class="inline-flex items-center gap-2 rounded-full bg-btn-light-bg px-6 py-3 font-sans font-medium text-white transition-colors duration-200 hover:bg-btn-light-bg-hover">
        {{ text }}
    </a>
</template>

<script setup lang="ts">
defineProps({
    link: {
        type: String,
        required: true
    },
    text: {
        type: String,
        required: true
    }
})
</script>

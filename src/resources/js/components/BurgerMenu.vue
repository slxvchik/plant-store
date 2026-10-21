<template>
    <div class="relative flex flex-col h-4 w-5 cursor-pointer">
        <span class="absolute top-0 h-0.5 w-full bg-bg-dark rounded transition-all duration-300"
            :class="{ 'rotate-45 top-[50%] translate-y-[-50%]': props.isOpen }"></span>

        <span
            class="absolute left-[50%] translate-x-[-50%] top-[50%] translate-y-[-50%] h-0.5 bg-bg-dark rounded transition-all duration-300"
            :class="props.isOpen ? 'opacity-0 w-0' : 'w-full'"></span>

        <span class="absolute bottom-0 h-0.5 w-full bg-bg-dark rounded transition-all duration-300"
            :class="{ '-rotate-45 top-[50%] translate-y-[-50%]': props.isOpen }"></span>
    </div>
</template>

<script setup lang="ts">
const props = defineProps(['isOpen']);
</script>
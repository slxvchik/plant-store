<template>
    <div class="relative flex h-4 w-5 cursor-pointer flex-col">
        <span
            :class="{ 'top-[50%] translate-y-[-50%] rotate-45': props.isOpen }"
            class="absolute top-0 h-0.5 w-full rounded bg-bg-dark transition-all duration-300"
        ></span>

        <span
            :class="props.isOpen ? 'w-0 opacity-0' : 'w-full'"
            class="absolute top-[50%] left-[50%] h-0.5 translate-x-[-50%] translate-y-[-50%] rounded bg-bg-dark transition-all duration-300"
        ></span>

        <span
            :class="{ 'top-[50%] translate-y-[-50%] -rotate-45': props.isOpen }"
            class="absolute bottom-0 h-0.5 w-full rounded bg-bg-dark transition-all duration-300"
        ></span>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps(['isOpen']);
</script>

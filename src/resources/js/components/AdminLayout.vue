<template>
    <div class="flex w-full min-w-screen">
        <SideBar />
        <div class="flex flex-col ml-80 p-5 w-full min-h-screen bg-bg-surface">
            <slot />
        </div>
    </div>
</template>

<script setup lang="ts">
import SideBar from './SideBar.vue';
</script>
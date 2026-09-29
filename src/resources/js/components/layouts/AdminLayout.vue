<template>
    <div class="flex w-full min-w-screen">
        <SideBar />
        <div class="flex flex-col ml-80 p-5 w-full min-h-screen bg-bg-surface">
            <slot />
        </div>
        <NotificationList />
    </div>
</template>

<script setup lang="ts">
import NotificationList from '@/components/NotificationList.vue';
import SideBar from '@/components/SideBar.vue';
</script>
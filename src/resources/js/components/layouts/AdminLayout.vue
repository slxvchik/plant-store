<template>
    <div class="flex min-h-screen w-full bg-bg-surface">
        <AdminSideBar />
        <div class="flex min-h-screen flex-1 flex-col bg-bg-surface p-5 pl-85">
            <slot />
        </div>
        <NotificationList />
    </div>
</template>

<script setup lang="ts">
import NotificationList from '@/components/NotificationList.vue';
import AdminSideBar from '@/components/AdminSideBar.vue';
</script>

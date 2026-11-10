<template>
    <div class="flex min-h-screen w-full bg-bg-surface">
        <AdminSideBar />
        <div class="flex min-h-screen flex-1 flex-col bg-bg-surface p-5 pl-85">
            <slot />
        </div>
        <NotificationList />
    </div>
</template>

<script lang="ts" setup>
import AdminSideBar from '@/components/AdminSideBar.vue';
import NotificationList from '@/components/NotificationList.vue';
</script>

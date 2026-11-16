<template>
    <div class="admin-layout">
        <AdminSidebar />
        <div class="admin-layout__content">
            <main class="admin-layout__main">
                <slot />
            </main>
        </div>
        <NotificationList />
    </div>
</template>

<script lang="ts" setup>
import AdminSidebar from '@/components/admin/AdminSideBar.vue';
import NotificationList from '@/components/notification/NotificationList.vue';
</script>

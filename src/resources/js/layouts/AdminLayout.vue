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
import AdminSidebar from '@/components/admin/AdminSidebar.vue';
import NotificationList from '@/components/notification/NotificationList.vue';
</script>

<style lang="scss" scoped>
.admin-layout {
    @apply min-h-screen w-full bg-slate-50 text-slate-900;

    &__content {
        @apply min-h-screen pl-20 lg:pl-72;
    }

    &__main {
        @apply mx-auto w-full max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8;
    }
}
</style>

<template>
    <div class="min-h-screen w-full bg-slate-50 text-slate-900">
        <AdminSideBar />
        <div class="min-h-screen pl-20 lg:pl-72">
            <main class="mx-auto w-full max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                <slot />
            </main>
        </div>
        <NotificationList />
    </div>
</template>

<script lang="ts" setup>
import AdminSideBar from '@/components/admin/AdminSideBar.vue';
import NotificationList from '@/components/NotificationList.vue';
</script>

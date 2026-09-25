<template>
    <div class="relative min-h-dvh w-full bg-bg-base">
        <Header />
        <slot />
        <Footer />
        <NotificationList />
    </div>
</template>

<script setup lang="ts">
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import NotificationList from '@/components/NotificationList.vue';
</script>
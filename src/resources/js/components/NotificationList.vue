<template>
    <TransitionGroup tag="div" name="notification"
        class="fixed top-4 left-1/2 z-50 flex w-full max-w-sm -translate-x-1/2 flex-col gap-3 px-4">
        <NotificationItem v-for="notification in store.items" :key="notification.id" :notification="notification" />
    </TransitionGroup>
</template>

<script setup lang="ts">
import { useNotificationStore } from '@/stores/useNotificationStore.js';
import NotificationItem from '@/components/NotificationItem.vue';

const store = useNotificationStore();
</script>

<style scoped>
.notification-enter-from {
    opacity: 0;
    transform: translateY(-20px);
}

.notification-leave-to {
    opacity: 0;
    transform: scale(0.95);
}

.notification-enter-active,
.notification-leave-active {
    transition: all 0.3s ease;
}

.notification-leave-active {
    position: absolute;
    width: 100%;
}

.notification-move {
    transition: transform 0.3s ease;
}
</style>

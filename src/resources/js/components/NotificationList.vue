<template>
    <TransitionGroup
        class="fixed top-4 left-1/2 z-999 flex w-full max-w-sm -translate-x-1/2 flex-col gap-3"
        name="notification"
        tag="div"
    >
        <NotificationItem
            v-for="notification in store.items"
            :key="notification.id"
            :notification="notification"
        />
    </TransitionGroup>
</template>

<script lang="ts" setup>
import NotificationItem from '@/components/NotificationItem.vue';
import { useNotificationStore } from '@/stores/useNotificationStore.js';

const store = useNotificationStore();
</script>

<style scoped>
.notification-move {
    transition: transform 0.5s ease;
}

.notification-enter-active,
.notification-leave-active {
    transition: all 0.5s ease;
}

.notification-leave-active {
    position: absolute;
    width: 100%;
}

.notification-enter-from {
    opacity: 0;
    transform: translateY(-20px);
    z-index: -1;
}

.notification-leave-to {
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
    z-index: -1;
}
</style>

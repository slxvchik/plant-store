<template>
    <div
        :class="getNotificationClass(notification.type)"
        class="animate-fade-in-down flex items-center justify-between rounded-lg p-4"
    >
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium">{{ notification.message }}</span>
        </div>
        <button
            :class="getButtonClass(notification.type)"
            class="ml-4 cursor-pointer focus:outline-none"
            @click="notificationStore.remove(notification.id)"
        >
            <span class="flex h-4 w-4"><CrossIcon /></span>
        </button>
    </div>
</template>

<script lang="ts" setup>
import CrossIcon from '@/components/icons/CrossIcon.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';
import type { NotificationItem } from '@/types/notification';

defineProps<{
    notification: NotificationItem;
}>();

const getNotificationClass = (type: NotificationItem['type']) => {
    switch (type) {
        case 'success':
            return 'bg-green-50 text-green-800';
        case 'warning':
            return 'bg-amber-50 text-amber-800';
        case 'error':
            return 'bg-red-50 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getButtonClass = (type: NotificationItem['type']) => {
    switch (type) {
        case 'success':
            return 'text-green-500 hover:text-green-700';
        case 'warning':
            return 'text-amber-500 hover:text-amber-700';
        case 'error':
            return 'text-red-500 hover:text-red-700';
        default:
            return 'text-gray-500 hover:text-gray-700';
    }
};

const notificationStore = useNotificationStore();
</script>

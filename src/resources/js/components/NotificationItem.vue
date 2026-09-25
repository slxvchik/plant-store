<template>
    <div class="flex items-center justify-between rounded-lg p-4 animate-fade-in-down"
        :class="getNotificationClass(notification.type)">
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium">{{ notification.message }}</span>
        </div>
        <button class="ml-4 cursor-pointer focus:outline-none" :class="getButtonClass(notification.type)"
            @click="notificationStore.remove(notification.id)">
            <CrossIcon class="w-4 h-4" />
        </button>
    </div>
</template>

<script setup lang="ts">
import CrossIcon from '@/components/icons/CrossIcon.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';

interface NotificationItem {
    id: string,
    type: 'info' | 'error' | 'success' | 'warning';
    message: string;
}

defineProps<{
    notification: NotificationItem;
}>();

const getNotificationClass = (type: NotificationItem['type']) => {
    return {
        'bg-gray-100 text-gray-800': !type,
        'bg-green-50 text-green-800': type === 'success',
        'bg-amber-50 text-amber-800': type === 'warning',
        'bg-red-50 text-red-800': type === 'error'
    };
};

const getButtonClass = (type: NotificationItem['type']) => {
    return {
        'text-gray-500 hover:text-gray-700': !type,
        'text-green-500 hover:text-green-700': type === 'success',
        'text-amber-500 hover:text-amber-700': type === 'warning',
        'text-red-500 hover:text-red-700': type === 'error'
    };
};

const notificationStore = useNotificationStore();
</script>
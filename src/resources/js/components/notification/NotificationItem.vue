<template>
    <div :class="rootClasses">
        <div class="notification-item__content">
            <span class="notification-item__message">
                {{ notification.message }}
            </span>
        </div>
        <Button
            style-type="link"
            :class="buttonClasses"
            @click="notificationStore.remove(notification.id)"
        >
            <span class="notification-item__icon"><Icon name="cross" /></span>
        </Button>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';
import type { NotificationItem } from '@/types/notification';

const props = defineProps<{ notification: NotificationItem }>();
const rootClasses = computed(() => [
    'notification-item',
    `notification-item--${props.notification.type}`,
]);
const buttonClasses = computed(() => [
    'notification-item__close',
    `notification-item__close--${props.notification.type}`,
]);
const notificationStore = useNotificationStore();
</script>

<template>
    <div v-if="store.items && store.items.length > 0" class="notifications">
        <Container>
            <TransitionGroup class="notifications__items" name="notification" tag="div">
                <NotificationItem
                    v-for="notification in store.items"
                    :key="notification.id"
                    :notification="notification"
                />
            </TransitionGroup>
        </Container>
    </div>
</template>
<script lang="ts" setup>
import Container from '@/components/Container.vue';
import NotificationItem from '@/components/notification/NotificationItem.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';

const store = useNotificationStore();
</script>
<style lang="scss" scoped>
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

import { defineStore } from 'pinia'
import { ref } from 'vue'

export interface NotificationItem {
    id: string;
    message: string;
    type: 'info' | 'error' | 'success' | 'warning';
}

export const useNotificationStore = defineStore('notification', () => {
    const items = ref<NotificationItem[]>([]);

    function add(message: string, type: NotificationItem['type'], duration = 4000) {
        const id = typeof crypto && 'randomUUID' in crypto
            ? crypto.randomUUID()
            : (Date.now().toString(36) + Math.random().toString(36).substring(2, 9));

        items.value.push({ id, message, type })

        setTimeout(() => {
            remove(id)
        }, duration)
    }

    function remove(id: string) {
        items.value = items.value.filter(item => item.id !== id)
    }

    return { items, add, remove }
})

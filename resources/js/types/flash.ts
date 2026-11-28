import type { NotificationItem } from '@/types/notification';

export type Flash = {
    response: unknown;
    message: string | null;
    type: NotificationItem['type'] | null;
};

import type { Image } from '@/types/image';

export const ORDER_STATUS_CREATED = 'Новый';
export const ORDER_STATUS_IN_PROGRESS = 'В обработке';
export const ORDER_STATUS_CANCELLED = 'Отменён';
export const ORDER_STATUS_COMPLETED = 'Завершён';

export type OrderUser = {
    id: string;
    firstName: string;
    lastName: string | null;
    email: string;
    phone: string;
};

export type OrderLine = {
    productId: string;
    offerId: string;
    imageResponseDto: Image | null;
    productName: string | null;
    quantity: number;
    unitPriceInKopecks: number;
    warehouseAddress: string;
};

export type Order = {
    id: string;
    status: string;
    orderLineResponseDto: OrderLine[];
    orderSumInKopecks: number;
    user: OrderUser;
};

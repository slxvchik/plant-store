import type { Image } from '@/types/image';

// Response
export type Cart = {
    cartId: string;
    userId: string | null;
    cartLines: CartLine[];
};

export type CartLine = {
    product: CartProduct;
    quantity: number;
    availableQuantity: number;
};

export type CartProduct = {
    productId: string;
    alias: string;
    name: string;
    images: Image[];
    offerId: string;
    active: boolean;
    sku: string;
    price: number;
    formFactor: string | null;
    size: string | null;
    age: number | null;
    sowingDate: string | null;
};

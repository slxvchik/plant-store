import type { UploadableImage } from '@/types/image';

export type SortedMediaInput = {
    id: string;
    sort: number;
};

export type StockFormState = {
    warehouseId: string;
    quantity: number;
    reserved: number;
};

export type OfferFormState = {
    clientKey: string;
    id?: string;
    active: boolean;
    sku: string;
    sort: number;
    description: string;
    price: number;
    stocks: StockFormState[];
    formFactor: string;
    size: string;
    age: number | null;
    sowingDate: string;
    images: UploadableImage[];
    videos: SortedMediaInput[];
};

export type ProductFormState = {
    id?: string;
    name: string;
    active: boolean;
    alias: string;
    sort: number;
    description: string;
    categories: string[];
    tags: string[];
    images: UploadableImage[];
    videos: SortedMediaInput[];
    offers: OfferFormState[];
};

export type OfferPayload = Omit<
    OfferFormState,
    'clientKey' | 'images'
> & {
    images: SortedMediaInput[];
};

export type ProductPayload = Omit<
    ProductFormState,
    'id' | 'images' | 'offers'
> & {
    images: SortedMediaInput[];
    offers: OfferPayload[];
};

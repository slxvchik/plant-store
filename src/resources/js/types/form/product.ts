import type { UploadableImage } from '@/types';

export interface ProductFormState {
    id?: string;
    name: string;
    active: boolean;
    alias: string;
    sort: number;
    description: string;
    categories: string[];
    images: UploadableImage[] | null;
}

export interface OfferFormState {
    id?: string;
    active: boolean;
    sku: string;
    sort: number;
    description?: string;
    price: number;
    stocks: StockFormState[];
    formFactor?: string;
    size?: string;
    age?: number;
    sowingDate?: string;
    images: UploadableImage[] | null;
    videos: null;
}

export interface StockFormState {
    warehouseId: string;
    quantity: number;
    reserved: number;
}

import type { Category } from '@/types/category';
import type  { Image, ImageFormState } from '@/types/image';
import type { Tag } from '@/types/tag';
import type { Video } from '@/types/video';
import type { Warehouse } from '@/types/warehouse';

// Response
export type Product = {
    id: string;
    active: boolean;
    alias: string;
    name: string;
    sort: number;
    description: string | null;
    offers: Offer[];
    categories: Category[];
    tags: Tag[];
    videos: Video[];
    images: Image[];
};

export type Offer = {
    id: string;
    active: boolean;
    sku: string;
    sort: number;
    description: string | null;
    price: number;
    stocks: Stock[];
    formFactor: string | null;
    size: string | null;
    age: number | null;
    sowingDate: string | null;
};

export type Stock = {
    warehouse: Warehouse;
    quantity: number;
    reserved: number;
};

// Form state
export type ProductFormState = {
    id?: string;
    name: string;
    active: boolean;
    alias: string;
    sort: number;
    description: string;
    categories: string[];
    tags: string[];
    images: ImageFormState[];
    offers: OfferFormState[];
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
    images: ImageFormState[];
};

export type StockFormState = {
    warehouseId: string;
    quantity: number;
    reserved: number;
};

// Requests
export type MediaSortedItemPayload = {
    id: string;
    sort: number;
};

export type ProductPayload = Omit<ProductFormState, 'id' | 'images' | 'videos' | 'offers'> & {
    images: MediaSortedItemPayload[];
    videos: MediaSortedItemPayload[];
    offers: OfferPayload[];
};

export type OfferPayload = Omit<OfferFormState, 'clientKey' | 'images' | 'videos'> & {
    images: MediaSortedItemPayload[];
    videos: MediaSortedItemPayload[];
};

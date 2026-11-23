import type { Category } from '@/types/category';
import type { Image, ImageFormState } from '@/types/image';
import type { Tag } from '@/types/tag';
import type { Video } from '@/types/video';

// Response
export type Product = {
    id: string;
    active: boolean;
    alias: string;
    name: string;
    sort: number;
    description: string | null;
    featured: boolean;
    minPrice: number;
    offers: Offer[];
    category: Category | null;
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
    stockQuantity: number | null;
};

// Form state
export type ProductFormState = {
    id?: string;
    name: string;
    active: boolean;
    alias: string;
    sort: number;
    description: string;
    category: string | null;
    featured: boolean;
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
    stockQuantity: number;
    images: ImageFormState[];
};

// Requests
export type MediaSortedItemPayload = {
    id: string;
    sort: number;
};

export type ProductPayload = Omit<
    ProductFormState,
    'id' | 'images' | 'videos' | 'offers'
> & {
    images: MediaSortedItemPayload[];
    videos: MediaSortedItemPayload[];
    offers: OfferPayload[];
};

export type OfferPayload = Omit<
    OfferFormState,
    'clientKey' | 'images' | 'videos'
> & {
    images: MediaSortedItemPayload[];
    videos: MediaSortedItemPayload[];
};

// Product search sort
export enum ProductSearchSort {
    SORT = 'sort',
    PRICE_ASC = 'price_asc',
    PRICE_DESC = 'price_desc',
}

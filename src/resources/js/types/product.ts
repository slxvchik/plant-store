import type { Category } from '@/types/category';
import type { Image } from '@/types/image';
import type { Tag } from '@/types/tag';
import type { Video } from '@/types/video';
import type { Warehouse } from '@/types/warehouse';

export type Product = {
    id: string;
    active: boolean;
    alias: string;
    name: string;
    description?: string;
    offers: Offer[];
    categories: Category[];
    tags: Tag[];
    videos: Video[];
    images: Image[];
}

export type Offer = {
    id: string;
    active: boolean;
    sku: string;
    description?: string;
    price: bigint;
    stocks: Stock[];
    formFactor?: string;
    size?: string;
    age?: bigint;
    sowingDate?: Date;
}

export type Stock = {
    warehouse: Warehouse;
    quantity: bigint;
    reserved: bigint;
}

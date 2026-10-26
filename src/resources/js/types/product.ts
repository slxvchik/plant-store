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

import { Warehouse } from '@/types/warehouse';
import { Category } from '@/types/category';
import { Tag } from '@/types/tag';
import { Video } from '@/types/video';
import { Image } from '@/types/image';

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

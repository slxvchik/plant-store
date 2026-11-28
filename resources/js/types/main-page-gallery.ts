import type { Image, ImageFormState } from '@/types/image.ts';

// Response
export type MainPageGallerySlide = {
    id: string;
    active: boolean;
    sort: number;
    image: Image;
    preTitle: string | null;
    title: string | null;
    description: string | null;
    buttonLink: string | null;
    buttonText: string | null;
};

// Form state
export type SlideFormState = {
    active: boolean;
    sort: number;
    images: ImageFormState[];
    preTitle: string;
    title: string;
    description: string;
    buttonLink: string;
    buttonText: string;
};

// Request
export type SlidePayload = {
    active: boolean;
    sort: number;
    imageId: string;
    preTitle: string | null;
    title: string | null;
    description: string | null;
    buttonLink: string | null;
    buttonText: string | null;
};

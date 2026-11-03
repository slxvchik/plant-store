import type { Image, ImageFormState } from '@/types/image.ts';

// Response
export type MainPageGallerySlide = {
    id: string;
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
    sort: number;
    imageId: string | null;
    preTitle: string | null;
    title: string | null;
    description: string | null;
    buttonLink: string | null;
    buttonText: string | null;
};

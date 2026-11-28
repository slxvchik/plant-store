//Response
export type Image = {
    id: string;
    webPathToFile: string;
    mimeType: string;
    sizeInBytes: number;
    width: number | null;
    height: number | null;
    titleText: string | null;
    altText: string | null;
};

// Form state
export type ImageFormState = {
    id?: string;
    pseudoId: string;
    file: File;
    previewUrl: string;
    titleText: string;
    altText: string;
    updated: boolean;
};

// Requests
export type CreateImagePayload = {
    file: File;
    titleText?: string;
    altText?: string;
    type?: ImageType;
};

export type UpdateImagePayload = Omit<CreateImagePayload, 'file' | 'folder'>;

export enum ImageType {
    Product = "product",
    MainPageGallery = "main_page_gallery"
}

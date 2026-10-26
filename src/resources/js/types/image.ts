export type Image = {
    id: string;
    path: string;
    mimeType: string;
    sizeInBytes: number;
    created: Date;
    width?: number;
    height?: number;
    titleText?: string;
    altText?: string;
};

export type UploadableImage = {
    id?: string;
    pseudoId: string;
    file: File;
    previewUrl: string;
    titleText?: string;
    altText?: string;
};

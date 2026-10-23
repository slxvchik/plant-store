export type Image = {
    id: string;
    path: string;
    mimeType: string;
    sizeInBytes: bigint;
    created: Date;
    width?: bigint;
    height?: bigint;
    titleText?: string;
    altText?: string;
};

export type UploadableImage = {
    id: string;
    file: File;
    previewUrl: string;
    titleText?: string;
    altText?: string;
};

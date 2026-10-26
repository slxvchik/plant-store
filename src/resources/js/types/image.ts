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

export type UploadableImage = {
    id?: string;
    pseudoId: string;
    file: File;
    previewUrl: string;
    titleText: string;
    altText: string;
};

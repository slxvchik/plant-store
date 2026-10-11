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

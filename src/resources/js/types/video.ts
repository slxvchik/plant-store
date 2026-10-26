export type Video = {
    id: string;
    webPathToFile: string;
    mimeType: string;
    sizeInBytes: number;
    width: number | null;
    height: number | null;
    loop: boolean;
    muted: boolean;
    durationSec: number | null;
    codec: string | null;
    thumbnailId: string | null;
};

import { Image } from '@/types/image';

export type Video = {
    id: string;
    path: string;
    mimeType: string;
    sizeInBytes: bigint;
    created: Date;
    width?: bigint;
    height?: bigint;
    loop: boolean;
    muted: boolean;
    durationSec?: bigint;
    codec?: string;
    thumbnail?: Image;
}

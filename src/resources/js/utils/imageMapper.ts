import type { Image, ImageFormState } from '@/types/image.ts';

export async function toImageFormState(image: Image): Promise<ImageFormState> {
    const imageResponse = await fetch(image.webPathToFile);
    const imageData = await imageResponse.blob();
    const file = new File([imageData], image.id, { type: image.mimeType });

    return {
        id: image.id,
        pseudoId: `${image.id}-${image.sizeInBytes}`,
        file: file,
        previewUrl: image.webPathToFile,
        titleText: image.titleText ?? '',
        altText: image.altText ?? '',
        updated: false,
    };
};

import AdminImage from '@/routes/admin/image';
import type {
    CreateImagePayload,
    Image,
    ImageType,
    ImageFormState,
    UpdateImagePayload,
} from '@/types/image.ts';

type CreatedImageResponse = {
    created: string;
};

export function useImageUploads() {
    let createdIds: string[] = [];

    const createImage = async (image: CreateImagePayload): Promise<string> => {
        const data = new FormData();
        data.append('file', image.file);

        if (image.titleText) {
            data.append('titleText', image.titleText);
        }

        if (image.altText) {
            data.append('altText', image.altText);
        }

        if (image.type) {
            data.append('type', image.type)
        }

        const response = await fetch(AdminImage.create.url(), {
            method: 'POST',
            // credentials: 'include',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: data,
        });
        const body: unknown = await response.json().catch(() => null);

        if (!response.ok || !isCreatedImageResponse(body)) {
            throw new Error(
                `Image upload failed with status ${response.status}.`,
            );
        }

        createdIds.push(body.created);

        return body.created;
    };

    const updateImage = async (id: string, image: UpdateImagePayload): Promise<string> => {
        fetch(AdminImage.update.url(id), {
            method: 'PUT',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({
                altText: image.altText,
                titleText: image.titleText,
            }),
        });

        return id;
    };

    const upload = async (images: ImageFormState[], type?: ImageType): Promise<string[]> => {
        return Promise.all(
            images.map(async (image) => {
                if (image.id) {
                    return image.updated ? await updateImage(image.id, {
                        altText: image.altText,
                        titleText: image.titleText,
                    }) : image.id;
                } else {
                    return await createImage({
                        file: image.file,
                        altText: image.altText,
                        titleText: image.titleText,
                        type: type,
                    });
                }
            }),
        );
    };

    const rollback = async (): Promise<void> => {
        const ids = createdIds;
        createdIds = [];

        await Promise.all(
            ids.map(async (id) => {
                const response = await fetch(AdminImage.destroy.url(id), {
                    method: 'DELETE',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    throw new Error(`Image rollback failed for ${id}.`);
                }
            }),
        );
    };

    const confirm = (): void => {
        createdIds = [];
    };

    const toImageFormState = async (image: Image): Promise<ImageFormState> => {
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
    }

    return { upload, rollback, confirm, toImageFormState };
}

function isCreatedImageResponse(value: unknown): value is CreatedImageResponse {
    return (
        typeof value === 'object' &&
        value !== null &&
        'created' in value &&
        typeof value.created === 'string'
    );
}

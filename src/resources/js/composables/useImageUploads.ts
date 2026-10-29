import AdminImage from '@/routes/admin/image';
import type { CreateImagePayload, ImageFormState, UpdateImagePayload } from '@/types/image.ts';

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

        const response = await fetch(AdminImage.create.url(), {
            method: 'POST',
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

    const upload = async (images: ImageFormState[]): Promise<string[]> => {
        return Promise.all(
            images.map(async (image) =>
                image.id ? (
                    await updateImage(image.id, {
                        altText: image.altText,
                        titleText: image.titleText,
                    })
                ) : (
                    await createImage({
                        file: image.file,
                        altText: image.altText,
                        titleText: image.titleText,
                    })
                )
            )
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

    return { upload, rollback, confirm };
}

function isCreatedImageResponse(value: unknown): value is CreatedImageResponse {
    return (
        typeof value === 'object' &&
        value !== null &&
        'created' in value &&
        typeof value.created === 'string'
    );
}

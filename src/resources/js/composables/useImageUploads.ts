import AdminImage from '@/routes/admin/image';
import type { SortedMediaInput } from '@/types/product';
import type { CreateImagePayload, ImageFormState } from '@/types/image';

type CreatedImageResponse = {
    created: string;
};

export function useImageUploads() {
    let uploadedIds: string[] = [];

    const csrfToken = (): string => {
        const token = document.querySelector<HTMLMetaElement>(
            'meta[name="csrf-token"]',
        )?.content;

        if (!token) {
            throw new Error('CSRF token is missing.');
        }

        return token;
    };

    const uploadImage = async (image: ImageFormState[]): Promise<string> => {
        const data = new FormData();
        data.append('file', image.file);
        data.append('titleText', image.titleText);
        data.append('altText', image.altText);

        const response = await fetch(AdminImage.create.url(), {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
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

        uploadedIds.push(body.created);

        return body.created;
    };

    const upload = async (images: ImageFormState[]): Promise<SortedMediaInput[]> => {
        return Promise.all(
            images.map(async (image, index) => ({
                id: image.id ?? (await uploadImage(image)),
                sort: 500 + index,
            })),
        );
    };

    const rollback = async (): Promise<void> => {
        const ids = uploadedIds;
        uploadedIds = [];

        await Promise.all(
            ids.map(async (id) => {
                const response = await fetch(AdminImage.destroy.url(id), {
                    method: 'DELETE',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
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
        uploadedIds = [];
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

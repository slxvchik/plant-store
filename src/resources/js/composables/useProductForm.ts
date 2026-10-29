import { useForm } from '@inertiajs/vue3';
import { useImageUploads } from '@/composables/useImageUploads.ts';
import AdminProduct from '@/routes/admin/products';
import { useNotificationStore } from '@/stores/useNotificationStore.ts';
import type  {
    OfferPayload,
    ProductFormState,
    ProductPayload,
    MediaSortedItemPayload,
} from '@/types/product.ts';

export function useProductForm() {
    const form = useForm<ProductFormState>({
        name: '',
        active: false,
        alias: '',
        sort: 500,
        description: '',
        categories: [],
        tags: [],
        images: [],
        offers: [],
    });
    const uploads = useImageUploads();
    const notifications = useNotificationStore();

    const submit = async (): Promise<void> => {
        try {
            const [productImages, offerImages] = await Promise.all([
                uploads.upload(form.images),
                Promise.all(
                    form.offers.map((offer) => uploads.upload(offer.images)),
                ),
            ]);
            const payload = serializeProduct(
                form.data(),
                productImages,
                offerImages,
            );

            form.transform(() => payload).post(AdminProduct.store.url(), {
                preserveScroll: true,
                onSuccess: () => {
                    uploads.confirm();
                    notifications.add('Товар успешно создан', 'success', 3000);
                },
                onError: (errors) => {
                    void uploads.rollback();
                    Object.values(errors).map((error) => {
                        notifications.add(error, 'error', 5000);
                    });
                },
            });
        } catch {
            await uploads.rollback();
            notifications.add(
                'Не удалось загрузить изображения',
                'error',
                5000,
            );
        }
    };

    return { form, submit };
}

function serializeProduct(
    form: ProductFormState,
    images: string[],
    offerImages: string[][],
): ProductPayload {
    return {
        name: form.name,
        active: form.active,
        alias: form.alias,
        sort: form.sort,
        description: form.description,
        categories: form.categories,
        tags: form.tags,
        images: getSortedItems(images),
        videos: [],
        offers: form.offers.map((offer, index): OfferPayload => {
            const { clientKey: _clientKey, images: _images, ...fields } = offer;

            return {
                ...fields,
                images: getSortedItems(offerImages[index]),
                videos: [],
            };
        }),
    };
}

function getSortedItems(itemId: string[]): MediaSortedItemPayload[] {
    return itemId.map((imageId, index) => ({
        id: imageId,
        sort: index,
    }));
}

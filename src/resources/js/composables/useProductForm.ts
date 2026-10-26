import { useForm } from '@inertiajs/vue3';
import { useImageUploads } from '@/composables/useImageUploads';
import AdminProduct from '@/routes/admin/products';
import { useNotificationStore } from '@/stores/useNotificationStore';
import type {
    OfferPayload,
    ProductFormState,
    ProductPayload,
} from '@/types/form/product';

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
        videos: [],
        offers: [],
    });
    const uploads = useImageUploads();
    const notifications = useNotificationStore();

    const submit = async (): Promise<void> => {
        try {
            const [productImages, offerImages] = await Promise.all([
                uploads.upload(form.images),
                Promise.all(form.offers.map((offer) => uploads.upload(offer.images))),
            ]);
            const payload = serializeProduct(form.data(), productImages, offerImages);

            form.transform(() => payload).post(AdminProduct.store.url(), {
                preserveScroll: true,
                onSuccess: () => {
                    uploads.confirm();
                    notifications.add('Товар успешно создан', 'success', 3000);
                },
                onError: () => {
                    void uploads.rollback();
                    notifications.add(
                        'Проверьте правильность заполнения полей',
                        'error',
                        5000,
                    );
                },
            });
        } catch {
            await uploads.rollback();
            notifications.add('Не удалось загрузить изображения', 'error', 5000);
        }
    };

    return { form, submit };
}

function serializeProduct(
    form: ProductFormState,
    images: { id: string; sort: number }[],
    offerImages: { id: string; sort: number }[][],
): ProductPayload {
    return {
        name: form.name,
        active: form.active,
        alias: form.alias,
        sort: form.sort,
        description: form.description,
        categories: form.categories,
        tags: form.tags,
        videos: form.videos,
        images,
        offers: form.offers.map((offer, index): OfferPayload => {
            const { clientKey: _clientKey, images: _images, ...fields } = offer;

            return { ...fields, images: offerImages[index] };
        }),
    };
}

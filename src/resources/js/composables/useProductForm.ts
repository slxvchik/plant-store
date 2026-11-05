import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useImageUploads } from '@/composables/useImageUploads.ts';
import AdminProduct from '@/routes/admin/products';
import { useNotificationStore } from '@/stores/useNotificationStore.ts';
import { ImageType } from '@/types/image.ts';
import type {
    MediaSortedItemPayload,
    OfferPayload,
    Product,
    ProductFormState,
    ProductPayload,
} from '@/types/product.ts';
import { toImageFormState } from '@/utils/imageMapper.ts';

type FormMode = 'create' | 'edit';

export function useProductForm(formMode: FormMode, product?: Product) {
    const form = useForm<ProductFormState>({
        name: product?.name ?? '',
        active: product?.active ?? false,
        alias: product?.alias ?? '',
        sort: product?.sort ?? 500,
        description: product?.description ?? '',
        categories: product?.categories.map((category) => category.id) ?? [],
        tags: product?.tags.map((tag) => tag.id) ?? [],
        images: [],
        offers:
            product?.offers.map((offer) => ({
                clientKey: offer.id,
                id: offer.id,
                active: offer.active,
                sku: offer.sku,
                sort: offer.sort,
                description: offer.description ?? '',
                price: offer.price,
                stocks: offer?.stocks.map((stock) => ({
                    warehouseId: stock.warehouse.id,
                    quantity: stock.quantity,
                    reserved: stock.reserved,
                })),
                formFactor: offer.formFactor ?? '',
                size: offer.size ?? '',
                age: offer.age,
                sowingDate: offer.sowingDate ?? '',
                images: [],
            })) ?? [],
    });
    const uploads = useImageUploads();
    const notifications = useNotificationStore();
    const isInitializing = ref(false);

    onMounted(async () => {
        if (product?.images && product.images.length > 0) {
            isInitializing.value = true;

            try {
                form.images = await Promise.all(
                    product.images.map((image) =>
                        toImageFormState(image),
                    ),
                );
            } catch (error) {
                notifications.add(
                    'Не удалось загрузить существующие изображения',
                    'error',
                    5000,
                );
                console.error(error);
            } finally {
                isInitializing.value = false;
            }
        }
    });

    const submit = async (): Promise<void> => {
        try {
            const [productImages, offerImages] = await Promise.all([
                uploads.upload(form.images, ImageType.Product),
                Promise.all(
                    form.offers.map((offer) =>
                        uploads.upload(offer.images, ImageType.Product),
                    ),
                ),
            ]);
            const payload = serializeProduct(
                form.data(),
                productImages,
                offerImages,
            );

            const isEdit = formMode === 'edit';
            const url =
                isEdit && product
                    ? AdminProduct.update.url(product.id)
                    : AdminProduct.store.url();
            const requestAction = isEdit ? form.put : form.post;

            form.transform(() => payload);
            requestAction(url, {
                preserveScroll: true,
                onSuccess: () => {
                    uploads.confirm();
                },
                onError: (errors) => {
                    void uploads.rollback();
                    Object.values(errors).map((error) => {
                        notifications.add(error, 'error', 5000);
                    });
                },
            });
        } catch (e) {
            console.error(e);
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

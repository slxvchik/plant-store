<template>
    <div class="flex flex-col gap-5">
        <h1 class="text-4xl text-text-title">Галерея главной страницы</h1>
        <div class="max-w-80">
            <Button text="Создать" secondary @click="openCreate" />
        </div>
    </div>
    <div
        class="mt-5 w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-5 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Сортировка</div>
            <div class="p-4">Заголовок</div>
            <div class="p-4">Подзаголовок</div>
            <div class="p-4">Текст кнопки</div>
            <div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="slide in slides"
                :key="slide.id"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="h-auto w-80">
                    <img
                        :src="slide.image.webPathToFile"
                        :alt="slide.image.altText ?? undefined"
                        :title="slide.image.titleText ?? undefined"
                        v-bind="
                            slide.image.width && slide.image.height
                                ? {
                                      width: slide.image.width,
                                      height: slide.image.height,
                                  }
                                : {}
                        "
                    />
                </div>
                <div class="p-4 font-medium text-gray-900">
                    {{ slide.sort }}
                </div>
                <div class="truncate p-4">{{ slide.title ?? '—' }}</div>
                <div class="truncate p-4">{{ slide.preTitle ?? '—' }}</div>
                <div class="truncate p-4">{{ slide.buttonText ?? '—' }}</div>
                <div class="flex gap-2 p-4">
                    <Button
                        text="Редактировать"
                        class="w-fit bg-yellow-400 hover:bg-yellow-500"
                        @click="openEdit(slide)"
                    />
                    <Button
                        text="Удалить"
                        class="w-fit bg-red-400 hover:bg-red-500"
                        @click="destroy(slide.id)"
                    />
                </div>
            </div>
        </div>
    </div>
    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать слайд' : 'Создать слайд'"
    >
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Input
                id="sort"
                v-model.number="form.sort"
                placeholder="500"
                type="number"
                label="Сортировка"
                :error="form.errors.sort"
                @update:modelValue="validateField('sort', form.sort)"
            />
            <div class="flex flex-col gap-1">
                <FileUpload
                    id="image"
                    v-model="form.images"
                    label="Изображение"
                    type="image"
                />
                <p v-if="isEditMode" class="text-xs text-gray-500">
                    Текущее изображение: {{ editingImageId }}. Загрузите новое,
                    чтобы заменить.
                </p>
                <p v-if="form.errors.images" class="text-red-400">
                    {{ form.errors.images }}
                </p>
            </div>
            <Input
                id="preTitle"
                v-model="form.preTitle"
                placeholder="Подзаголовок"
                label="Подзаголовок"
                :error="form.errors.preTitle"
            />
            <Input
                id="title"
                v-model="form.title"
                placeholder="Заголовок"
                label="Заголовок"
                :error="form.errors.title"
            />
            <Textarea
                id="description"
                v-model="form.description"
                label="Описание"
                :error="form.errors.description"
            />
            <Input
                id="buttonLink"
                v-model="form.buttonLink"
                placeholder="Ссылка кнопки"
                label="Ссылка кнопки"
                :error="form.errors.buttonLink"
            />
            <Input
                id="buttonText"
                v-model="form.buttonText"
                placeholder="Текст кнопки"
                label="Текст кнопки"
                :error="form.errors.buttonText"
            />
            <Button
                type="submit"
                secondary
                :disabled="form.processing"
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] max-w-80 translate-x-[-50%]"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import FileUpload from '@/components/FileUpload.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import { useImageUploads } from '@/composables/useImageUploads';
import AdminMainPageGallery from '@/routes/admin/main-page/gallery';
import { useNotificationStore } from '@/stores/useNotificationStore';
import type {
    MainPageGallerySlide,
    SlideFormState,
    SlidePayload,
} from '@/types/main-page-gallery.ts';
import { validate } from '@/utils/validator.ts';

defineOptions({ layout: AdminLayout });
defineProps<{ slides: MainPageGallerySlide[] }>();

const createData = (): SlideFormState => ({
    sort: 500,
    images: [],
    preTitle: '',
    title: '',
    description: '',
    buttonLink: '',
    buttonText: '',
});
const slideValidator = (field: keyof SlideFormState, value: any) => {
    switch (field) {
        case 'sort':
            return validate(
                value,
                'required|positiveInteger',
                'Введите корректную сортировку',
            );
        case 'images':
            return validate(
                value,
                'required',
                'Изображение для слайда галлереи обязательно',
            )
        default:
            return null;
    }
};
const {
    form,
    validateField,
    validateForm,
    isFormPopupOpen,
    isEditMode,
    editingId,
    openCreateModal,
    openEditModal,
    destroy,
} = useAdminCrudForm<SlideFormState, MainPageGallerySlide>({
    createData,
    editData: (slide) => ({
        sort: slide.sort,
        images: [],
        preTitle: slide.preTitle ?? '',
        title: slide.title ?? '',
        description: slide.description ?? '',
        buttonLink: slide.buttonLink ?? '',
        buttonText: slide.buttonText ?? '',
    }),
    routes: {
        store: () => AdminMainPageGallery.store.url(),
        update: (id) => AdminMainPageGallery.update.url(id),
        destroy: (id) => AdminMainPageGallery.destroy.url(id),
    },
    validator: slideValidator,
});

const uploads = useImageUploads();
const notifications = useNotificationStore();
const editingImageId = ref<string | null>(null);

const openCreate = (): void => {
    editingImageId.value = null;
    openCreateModal();
};
const openEdit = (slide: MainPageGallerySlide): void => {
    editingImageId.value = slide.image.id;
    openEditModal(slide);
};

const emptyToNull = (value: string): string | null =>
    value.trim() === '' ? null : value;

const submit = async (): Promise<void> => {
    const frontendErrors = validateForm(form);

    if (Object.keys(frontendErrors).length > 0) {
        Object.values(frontendErrors).forEach((error) => {
            if (error) {
                notifications.add(error, 'error');
            }
        });

        return;
    }

    if (!isEditMode.value && form.images.length === 0) {
        form.setError('images' as never, 'Изображение обязательно');
        notifications.add('Изображение обязательно', 'error');

        return;
    }

    try {
        const images = await uploads.upload(form.images);
        const payload: SlidePayload = {
            sort: form.sort,
            imageId: images[0]?.id ?? null,
            preTitle: emptyToNull(form.preTitle),
            title: emptyToNull(form.title),
            description: emptyToNull(form.description),
            buttonLink: emptyToNull(form.buttonLink),
            buttonText: emptyToNull(form.buttonText),
        };

        form.transform(() => payload);

        const id = editingId.value;
        const request = id === null ? form.post : form.put;
        request(
            id === null
                ? AdminMainPageGallery.store.url()
                : AdminMainPageGallery.update.url(id),
            {
                preserveScroll: true,
                onSuccess: () => {
                    uploads.confirm();
                    isFormPopupOpen.value = false;
                    form.clearErrors();
                },
                onError: (errors) => {
                    void uploads.rollback();
                    Object.values(errors).forEach((error) => {
                        notifications.add(error, 'error', 5000);
                    });
                },
            },
        );
    } catch {
        await uploads.rollback();
        notifications.add('Не удалось загрузить изображение', 'error', 5000);
    }
};
</script>

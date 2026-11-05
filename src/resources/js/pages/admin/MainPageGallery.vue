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
            class="grid grid-cols-6 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Изображение</div>
            <div class="p-4">Активность</div>
            <div class="p-4">Сортировка</div>
            <div class="p-4">Заголовок</div>
            <div class="p-4">Подзаголовок</div>
            <div class="p-4">Действие</div>
        </div>
        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="slide in slidesPage.items"
                :key="slide.id"
                class="grid grid-cols-6 transition-colors hover:bg-gray-50"
            >
                <div class="flex h-full w-full items-center justify-center p-2">
                    <img
                        :src="slide.image.webPathToFile"
                        :alt="slide.image.altText ?? undefined"
                        :title="slide.image.titleText ?? undefined"
                        class="h-40 w-40 object-cover"
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
                    {{ slide.active }}
                </div>
                <div class="p-4 font-medium text-gray-900">
                    {{ slide.sort }}
                </div>
                <div class="truncate p-4">{{ slide.title ?? '—' }}</div>
                <div class="truncate p-4">{{ slide.preTitle ?? '—' }}</div>
                <div class="flex flex-col items-center gap-2 p-4">
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
            <Checkbox id="active" v-model="form.active" text="Активность" />
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
                <ImageUpload
                    id="image"
                    v-model="form.images"
                    label="Изображение"
                    type="image"
                />
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
import Button from '@/components/Button.vue';
import ImageUpload from '@/components/ImageUpload.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import { useImageUploads } from '@/composables/useImageUploads';
import AdminMainPageGallery from '@/routes/admin/main-page/gallery';
import { ImageType } from '@/types/image.ts';
import type {
    MainPageGallerySlide,
    SlideFormState,
    SlidePayload,
} from '@/types/main-page-gallery.ts';
import type { Page } from '@/types/pagination.ts';
import { toImageFormState } from '@/utils/imageMapper.ts';
import { validate } from '@/utils/validator.ts';
import Checkbox from '@/components/Checkbox.vue';

defineOptions({ layout: AdminLayout });
defineProps<{ slidesPage: Page<MainPageGallerySlide> }>();

const uploads = useImageUploads();

const createData = (): SlideFormState => ({
    active: false,
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
            );
        default:
            return null;
    }
};
const {
    form,
    validateField,
    isFormPopupOpen,
    isEditMode,
    openCreateModal,
    openEditModal,
    destroy,
    submit,
} = useAdminCrudForm<SlideFormState, MainPageGallerySlide>({
    createData,
    editData: async (slide) => {
        const uploadedImage = await toImageFormState(slide.image);

        return {
            active: slide.active,
            sort: slide.sort,
            images: Array(uploadedImage),
            preTitle: slide.preTitle ?? '',
            title: slide.title ?? '',
            description: slide.description ?? '',
            buttonLink: slide.buttonLink ?? '',
            buttonText: slide.buttonText ?? '',
        };
    },
    routes: {
        store: () => AdminMainPageGallery.store.url(),
        update: (id) => AdminMainPageGallery.update.url(id),
        destroy: (id) => AdminMainPageGallery.destroy.url(id),
    },
    validator: slideValidator,
    onSubmitError: async () => {
        await uploads.rollback();
    },
    preSubmitAction: async () => {
        if (form.images.length === 0) {
            throw Error('Изображение обязательно');
        }

        const imageId = await uploads.upload(
            [form.images[0]],
            ImageType.MainPageGallery,
        );
        form.images[0].id = imageId[0];
    },
    formTransform: (slide: SlideFormState): SlidePayload => ({
        active: slide.active,
        sort: slide.sort,
        imageId: slide.images[0]?.id ?? '',
        preTitle: slide.preTitle,
        title: slide.title,
        description: slide.description,
        buttonLink: slide.buttonLink,
        buttonText: slide.buttonText,
    }),
});
const openCreate = (): void => {
    openCreateModal();
};
const openEdit = (slide: MainPageGallerySlide): void => {
    openEditModal(slide);
};
</script>

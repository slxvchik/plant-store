<template>
    <div class="main-page-gallery">
        <AdminPageHeader
            description="Слайды, их порядок и видимость на главной странице."
            eyebrow="Контент"
            title="Галерея главной страницы"
        >
            <template #actions>
                <Button
                    auto-width
                    secondary
                    text="Добавить слайд"
                    @click="openCreate"
                />
            </template>
        </AdminPageHeader>
        <Table>
            <thead>
                <tr>
                    <th>Изображение</th>
                    <th>Активность</th>
                    <th>Сортировка</th>
                    <th>Заголовок</th>
                    <th>Подзаголовок</th>
                    <th class="main-page-gallery__cell--actions">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="slide in slidesPage.items" :key="slide.id">
                    <td>
                        <img
                            :alt="slide.image.altText ?? undefined"
                            :src="slide.image.webPathToFile"
                            :title="slide.image.titleText ?? undefined"
                            class="main-page-gallery__image"
                            v-bind="
                                slide.image.width && slide.image.height
                                    ? {
                                          width: slide.image.width,
                                          height: slide.image.height,
                                      }
                                    : {}
                            "
                        />
                    </td>
                    <td>
                        <Badge
                            :label="slide.active ? 'Активен' : 'Скрыт'"
                            :tone="slide.active ? 'success' : 'neutral'"
                        />
                    </td>
                    <td class="main-page-gallery__sort">{{ slide.sort }}</td>
                    <td class="main-page-gallery__title">
                        {{ slide.title ?? '—' }}
                    </td>
                    <td class="main-page-gallery__pre-title">
                        {{ slide.preTitle ?? '—' }}
                    </td>
                    <td>
                        <div class="main-page-gallery__actions">
                            <Button
                                auto-width
                                ghost
                                small
                                text="Изменить"
                                @click="openEdit(slide)"
                            />
                            <Button
                                auto-width
                                danger
                                ghost
                                small
                                text="Удалить"
                                @click="destroy(slide.id)"
                            />
                        </div>
                    </td>
                </tr>
                <tr v-if="slidesPage.items.length === 0">
                    <td class="main-page-gallery__empty" colspan="6">
                        Слайды ещё не добавлены.
                    </td>
                </tr>
            </tbody>
        </Table>
        <Modal
            v-model:open="isFormPopupOpen"
            :title="isEditMode ? 'Редактировать слайд' : 'Создать слайд'"
        >
            <form class="main-page-gallery__form" @submit.prevent="submit">
                <Checkbox
                    id="active"
                    v-model="form.active"
                    :error="form.errors.active"
                    text="Активность"
                />
                <Input
                    id="sort"
                    v-model.number="form.sort"
                    :error="form.errors.sort"
                    label="Сортировка"
                    type="number"
                    @update:modelValue="
                        validateField && validateField('sort', form.sort)
                    "
                />
                <div class="main-page-gallery__upload">
                    <ImageUpload
                        id="image"
                        v-model="form.images"
                        label="Изображение"
                        type="image"
                    />
                    <p
                        v-if="form.errors.images"
                        class="main-page-gallery__error"
                    >
                        {{ form.errors.images }}
                    </p>
                </div>
                <div class="main-page-gallery__fields">
                    <Input
                        id="preTitle"
                        v-model="form.preTitle"
                        :error="form.errors.preTitle"
                        label="Подзаголовок"
                    />
                    <Input
                        id="title"
                        v-model="form.title"
                        :error="form.errors.title"
                        label="Заголовок"
                    />
                </div>
                <Textarea
                    id="description"
                    v-model="form.description"
                    :error="form.errors.description"
                    label="Описание"
                />
                <div class="main-page-gallery__fields">
                    <Input
                        id="buttonLink"
                        v-model="form.buttonLink"
                        :error="form.errors.buttonLink"
                        label="Ссылка кнопки"
                    />
                    <Input
                        id="buttonText"
                        v-model="form.buttonText"
                        :error="form.errors.buttonText"
                        label="Текст кнопки"
                    />
                </div>
                <div class="main-page-gallery__form-footer">
                    <Button
                        :disabled="form.processing"
                        :text="isEditMode ? 'Сохранить' : 'Создать'"
                        auto-width
                        secondary
                        type="submit"
                    />
                </div>
            </form>
        </Modal>
    </div>
</template>

<script lang="ts" setup>
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import Checkbox from '@/components/Checkbox.vue';
import ImageUpload from '@/components/ImageUpload.vue';
import Input from '@/components/Input.vue';
import Modal from '@/components/Modal.vue';
import Table from '@/components/Table.vue';
import Textarea from '@/components/Textarea.vue';
import { useAdminCrudForm } from '@/composables/useAdminCrudForm';
import { useImageUploads } from '@/composables/useImageUploads';
import AdminLayout from '@/layouts/AdminLayout.vue';
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
    formValidator,
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
const validateField = formValidator?.validateField;
const openCreate = (): void => {
    openCreateModal();
};
const openEdit = (slide: MainPageGallerySlide): void => {
    openEditModal(slide);
};
</script>

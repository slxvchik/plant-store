<template>
    <div class="space-y-6">
        <AdminPageHeader title="Галерея главной страницы" eyebrow="Контент" description="Слайды, их порядок и видимость на главной странице.">
            <template #actions><Button text="Добавить слайд" secondary class="!w-auto !rounded-xl !px-5 !py-2.5 !text-sm" @click="openCreate" /></template>
        </AdminPageHeader>
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto"><table class="w-full min-w-[1000px] text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold tracking-wider text-slate-500 uppercase"><tr><th class="px-5 py-4">Изображение</th><th class="px-5 py-4">Активность</th><th class="px-5 py-4">Сортировка</th><th class="px-5 py-4">Заголовок</th><th class="px-5 py-4">Подзаголовок</th><th class="px-5 py-4 text-right">Действия</th></tr></thead>
                <tbody class="divide-y divide-slate-100"><tr v-for="slide in slidesPage.items" :key="slide.id" class="hover:bg-slate-50">
                    <td class="px-5 py-4"><img :src="slide.image.webPathToFile" :alt="slide.image.altText ?? undefined" :title="slide.image.titleText ?? undefined" class="h-20 w-28 rounded-xl object-cover" v-bind="slide.image.width && slide.image.height ? { width: slide.image.width, height: slide.image.height } : {}" /></td>
                    <td class="px-5 py-4"><Badge :label="slide.active ? 'Активен' : 'Скрыт'" :tone="slide.active ? 'success' : 'neutral'" /></td><td class="px-5 py-4 text-slate-500">{{ slide.sort }}</td><td class="max-w-56 truncate px-5 py-4 font-semibold text-slate-900">{{ slide.title ?? '—' }}</td><td class="max-w-56 truncate px-5 py-4 text-slate-500">{{ slide.preTitle ?? '—' }}</td>
                    <td class="px-5 py-4"><div class="flex justify-end gap-2"><Button text="Изменить" class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-slate-600 hover:!bg-slate-100" @click="openEdit(slide)" /><Button text="Удалить" class="!w-auto !rounded-lg !bg-transparent !px-3 !py-2 !text-xs !text-rose-600 hover:!bg-rose-50" @click="destroy(slide.id)" /></div></td>
                </tr><tr v-if="slidesPage.items.length === 0"><td colspan="6" class="px-5 py-16 text-center text-slate-500">Слайды ещё не добавлены.</td></tr></tbody>
            </table></div>
        </section>
    </div>
    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать слайд' : 'Создать слайд'">
        <form class="flex w-full flex-col gap-5" @submit.prevent="submit">
            <Checkbox id="active" v-model="form.active" text="Активность" :error="form.errors.active" />
            <Input id="sort" v-model.number="form.sort" type="number" label="Сортировка" :error="form.errors.sort" @update:modelValue="validateField && validateField('sort', form.sort)" />
            <div class="flex flex-col gap-1"><ImageUpload id="image" v-model="form.images" label="Изображение" type="image" /><p v-if="form.errors.images" class="text-xs font-medium text-rose-600">{{ form.errors.images }}</p></div>
            <div class="grid gap-5 sm:grid-cols-2"><Input id="preTitle" v-model="form.preTitle" label="Подзаголовок" :error="form.errors.preTitle" /><Input id="title" v-model="form.title" label="Заголовок" :error="form.errors.title" /></div>
            <Input id="description" v-model="form.description" label="Описание" :error="form.errors.description" multiline />
            <div class="grid gap-5 sm:grid-cols-2"><Input id="buttonLink" v-model="form.buttonLink" label="Ссылка кнопки" :error="form.errors.buttonLink" /><Input id="buttonText" v-model="form.buttonText" label="Текст кнопки" :error="form.errors.buttonText" /></div>
            <div class="flex justify-end border-t border-slate-100 pt-5"><Button type="submit" secondary :disabled="form.processing" :text="isEditMode ? 'Сохранить' : 'Создать'" class="!w-auto !rounded-xl !px-5 !text-sm" /></div>
        </form>
    </Popup>
</template>

<script setup lang="ts">
import Badge from '@/components/Badge.vue';
import Button from '@/components/Button.vue';
import AdminPageHeader from '@/components/admin/AdminPageHeader.vue';
import Checkbox from '@/components/Checkbox.vue';
import ImageUpload from '@/components/ImageUpload.vue';
import Input from '@/components/Input.vue';
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
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

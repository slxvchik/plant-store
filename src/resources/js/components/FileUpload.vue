<template>
    <div class="flex flex-col gap-2">
        <div v-if="label" class="mb-1.5 text-text-muted select-none">
            {{ label }}
        </div>
        <div
            class="flex flex-row flex-wrap gap-2"
            v-if="modelValue !== null && type === 'image'"
        >
            <div
                class="relative"
                v-for="image in modelValue.values()"
                :key="image.id"
            >
                <img
                    :src="image.previewUrl"
                    :alt="image.file.name"
                    width="200"
                    height="200"
                    class="rounded object-cover"
                />
                <div class="flex flex-col gap-2">
                    <input
                        v-model="image.titleText"
                        type="text"
                        placeholder="Title текст"
                    />
                    <input
                        v-model="image.altText"
                        type="text"
                        placeholder="Alt текст"
                    />
                </div>
                <div
                    @click="removeFile(image.id)"
                    class="absolute top-1 right-1 h-10 w-10 cursor-pointer rounded-lg bg-white text-secondary transition-colors duration-300 hover:text-secondary-hover"
                >
                    <TrashBasket />
                </div>
            </div>
        </div>
        <input
            ref="fileInput"
            :id="id"
            type="file"
            multiple
            @change="handleFileChange"
        />
    </div>
</template>

<script setup lang="ts">
import { onBeforeUnmount, ref } from 'vue';
import TrashBasket from '@/components/icons/TrashBasket.vue';
import type { UploadableImage } from '@/types';

interface Props {
    id: string;
    label?: string;
    type: 'image' | 'video';
}

defineProps<Props>();

const fileInput = ref<HTMLInputElement | null>(null);

const modelValue = defineModel<UploadableImage[] | null>({ default: null });

const clearPreviews = () => {
    if (modelValue.value === null) {
        return;
    }

    modelValue.value.forEach((img) => URL.revokeObjectURL(img.previewUrl));
    modelValue.value = [];
};

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files && target.files.length > 0) {
        modelValue.value = Array.from(target.files).map((file) => ({
            id: `${file.name}-${file.size}-${file.lastModified}`,
            file: file,
            previewUrl: URL.createObjectURL(file),
            titleText: '',
            altText: '',
        }));
    } else {
        modelValue.value = null;
    }
};

const removeFile = (id: string) => {
    if (!modelValue.value) {
        return;
    }

    const fileIndex = modelValue.value.findIndex((image) => image.id === id);

    if (fileIndex === -1) {
        return;
    }

    URL.revokeObjectURL(modelValue.value[fileIndex].previewUrl);
    modelValue.value.splice(fileIndex, 1);

    if (modelValue.value.length === 0) {
        modelValue.value = null;
    }

    if (fileInput.value) {
        if (modelValue.value !== null) {
            const dataTransfer = new DataTransfer();

            modelValue.value.forEach((file) =>
                dataTransfer.items.add(file.file),
            );

            fileInput.value.files = dataTransfer.files;
        } else {
            fileInput.value.value = '';
        }
    }
};

onBeforeUnmount(() => {
    clearPreviews();
});
</script>

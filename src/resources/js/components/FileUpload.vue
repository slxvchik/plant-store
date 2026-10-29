<template>
    <div class="flex flex-col gap-2">
        <div
            v-if="label"
            class="mb-1.5 select-none"
            :class="!error ? 'text-text-muted' : 'text-red-400'"
        >
            {{ label }}
        </div>
        <div
            v-if="modelValue.length && type === 'image'"
            class="flex flex-row flex-wrap gap-2"
        >
            <div
                v-for="image in modelValue"
                :key="image.pseudoId"
                class="relative"
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
                <button
                    type="button"
                    class="absolute top-1 right-1 h-10 w-10 cursor-pointer rounded-lg bg-white text-secondary transition-colors duration-300 hover:text-secondary-hover"
                    @click="removeFile(image)"
                >
                    <TrashBasket />
                </button>
            </div>
        </div>
        <input
            :id="id"
            ref="fileInput"
            type="file"
            multiple
            :accept="acceptTypes"
            @change="handleFileChange"
        />
        <p v-if="error" class="text-red-400">
            {{ error }}
        </p>
    </div>
</template>

<script setup lang="ts">
import { computed, onBeforeUnmount, ref, watch } from 'vue';
import TrashBasket from '@/components/icons/TrashBasket.vue';
import type { ImageFormState } from '@/types/image';
import { validate } from '@/utils/validator.ts';

interface Props {
    id: string;
    label?: string;
    type?: 'image' | 'video';
    error?: string;
    rules?: string;
}

const props = defineProps<Props>();
const modelValue = defineModel<ImageFormState[]>({ default: () => [] });
const fileInput = ref<HTMLInputElement | null>(null);

const acceptTypes = computed(() => {
    if (props.type === 'image') {
        return 'image/jpeg,image/png,image/webp';
    }

    if (props.type === 'video') {
        return 'video/mp4,video/webm';
    }

    return undefined;
});

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;

    modelValue.value.forEach((image) => URL.revokeObjectURL(image.previewUrl));
    modelValue.value = Array.from(target.files ?? []).map((file) => ({
        pseudoId: `${file.name}-${file.size}-${file.lastModified}`,
        file,
        previewUrl: URL.createObjectURL(file),
        titleText: '',
        altText: '',
    }));
};

const removeFile = (image: ImageFormState) => {
    URL.revokeObjectURL(image.previewUrl);
    modelValue.value = modelValue.value.filter((item) => item !== image);

    const dataTransfer = new DataTransfer();
    modelValue.value.forEach((item) => dataTransfer.items.add(item.file));

    if (fileInput.value) {
        fileInput.value.files = dataTransfer.files;
    }
};

onBeforeUnmount(() => {
    modelValue.value.forEach((image) => URL.revokeObjectURL(image.previewUrl));
});
</script>

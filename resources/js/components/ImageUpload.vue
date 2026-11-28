<template>
    <div class="image-upload">
        <div v-if="label" class="image-upload__label">{{ label }}</div>
        <div v-if="modelValue.length" class="image-upload__items">
            <div
                v-for="image in modelValue"
                :key="image.pseudoId"
                class="image-upload__item"
            >
                <div class="image-upload__preview">
                    <img
                        :alt="image.file.name"
                        :src="image.previewUrl"
                        class="image-upload__image"
                    />
                </div>
                <div class="image-upload__fields">
                    <Input
                        :id="`${image.id}-title`"
                        v-model="image.titleText"
                        :disabled="disabled"
                        label="Title текст"
                        @change="imageChange(image)"
                    />
                    <Input
                        :id="`${image.id}-alt`"
                        v-model="image.altText"
                        :disabled="disabled"
                        label="Alt текст"
                        @change="imageChange(image)"
                    />
                </div>
                <Button
                    v-if="!disabled"
                    aria-label="Удалить изображение"
                    class="image-upload__remove"
                    ghost
                    type="button"
                    @click="removeFile(image)"
                >
                    <Icon name="trash" />
                </Button>
            </div>
        </div>
        <input
            :id="id"
            ref="fileInput"
            :disabled="disabled"
            :multiple="multiple"
            accept="image/jpeg,image/png,image/webp"
            class="image-upload__input"
            type="file"
            @change="handleFileChange"
        />
        <p v-if="error" class="image-upload__error">{{ error }}</p>
    </div>
</template>

<script lang="ts" setup>
import { onBeforeUnmount, ref } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import Input from '@/components/Input.vue';
import type { ImageFormState } from '@/types/image';

withDefaults(
    defineProps<{
        id: string;
        label?: string;
        error?: string;
        disabled?: boolean;
        multiple?: boolean;
    }>(),
    { multiple: false },
);
const modelValue = defineModel<ImageFormState[]>({ default: () => [] });
const fileInput = ref<HTMLInputElement | null>(null);
const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    modelValue.value.forEach((image) => URL.revokeObjectURL(image.previewUrl));
    modelValue.value = Array.from(target.files ?? []).map((file) => ({
        pseudoId: `${file.name}-${file.size}-${file.lastModified}`,
        file,
        previewUrl: URL.createObjectURL(file),
        titleText: '',
        altText: '',
        updated: false,
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
const imageChange = (image: ImageFormState) => {
    image.updated = true;
};
onBeforeUnmount(() =>
    modelValue.value.forEach((image) => URL.revokeObjectURL(image.previewUrl)),
);
</script>

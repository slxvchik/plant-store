<template>
    <div class="flex flex-col gap-2">
        <div
            v-if="label"
            :class="!error ? 'text-text-muted' : 'text-red-400'"
            class="mb-1.5 select-none"
        >
            {{ label }}
        </div>
        <div v-if="modelValue.length" class="flex flex-row flex-wrap gap-2">
            <div
                v-for="image in modelValue"
                :key="image.pseudoId"
                class="relative flex w-50 flex-col gap-4"
            >
                <div class="h-50">
                    <img
                        :alt="image.file.name"
                        :src="image.previewUrl"
                        class="h-full w-full rounded object-cover"
                        height="200"
                        width="200"
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <Input
                        :id="`${image.id}-title`"
                        v-model="image.titleText"
                        :disabled="disabled"
                        label="Title текст"
                        type="text"
                        @change="imageChange(image)"
                    />
                    <Input
                        :id="`${image.id}-alt`"
                        v-model="image.altText"
                        :disabled="disabled"
                        label="Alt текст"
                        type="text"
                        @change="imageChange(image)"
                    />
                </div>
                <button
                    v-if="!disabled"
                    class="absolute top-1 right-1 h-10 w-10 cursor-pointer rounded-lg bg-white text-secondary transition-colors duration-300 hover:text-secondary-hover"
                    type="button"
                    @click="removeFile(image)"
                >
                    <TrashBasket />
                </button>
            </div>
        </div>
        <input
            :id="id"
            ref="fileInput"
            :disabled="disabled"
            :multiple="multiple"
            accept="image/jpeg,image/png,image/webp"
            type="file"
            @change="handleFileChange"
        />
        <p v-if="error" class="text-red-400">
            {{ error }}
        </p>
    </div>
</template>

<script lang="ts" setup>
import { onBeforeUnmount, ref } from 'vue';
import TrashBasket from '@/components/icons/TrashBasket.vue';
import Input from '@/components/Input.vue';
import type { ImageFormState } from '@/types/image';

interface Props {
    id: string;
    label?: string;
    error?: string;
    disabled?: boolean;
    multiple?: boolean;
}

defineProps<Props>();
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

onBeforeUnmount(() => {
    modelValue.value.forEach((image) => URL.revokeObjectURL(image.previewUrl));
});
</script>

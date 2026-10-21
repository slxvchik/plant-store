<template>
    <Button
        text="Создать"
        class="mb-5 max-w-80 rounded-lg"
        @click="openCreateModal"
    />
    <div
        class="w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm"
    >
        <div
            class="grid grid-cols-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold tracking-wider text-gray-500 uppercase"
        >
            <div class="p-4">Id</div>
            <div class="p-4">Алиас</div>
            <div class="p-4">Сортировка</div>
            <div class="p-4">Название</div>
            <div class="p-4">Активность</div>
        </div>

        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div
                v-for="tag in tagsPage.items"
                :key="tag.id"
                class="grid grid-cols-5 transition-colors hover:bg-gray-50"
            >
                <div class="p-4 font-medium text-gray-900">#{{ tag.id }}</div>
                <div class="truncate p-4">{{ tag.alias }}</div>
                <div class="p-4">{{ tag.name }}</div>
                <div class="p-4 whitespace-nowrap">{{ tag.sort ?? '-' }}</div>
                <div class="p-4">{{ tag.active }}</div>
                <div class="flex gap-2 p-4">
                    <Button
                        text="Редактировать"
                        class="w-fit rounded-lg bg-yellow-400 hover:bg-yellow-500"
                        @click="openEditModal(tag)"
                    />
                    <Button
                        text="Удалить"
                        class="w-fit rounded-lg bg-red-400 hover:bg-red-500"
                        @click="deleteTag(tag.id)"
                    />
                </div>
            </div>
        </div>
    </div>

    <Popup
        v-model:open="isFormPopupOpen"
        :title="isEditMode ? 'Редактировать тег' : 'Создать тег'"
    >
        <form class="flex w-full flex-col">
            <Input
                id="alias"
                placeholder="tag-1"
                label="Алиас"
                v-model="tagAlias"
            />
            <Input
                id="name"
                placeholder="Тег 1"
                label="Название"
                class="mt-5"
                v-model="tagName"
            />
            <Input
                id="name"
                placeholder="Тег 1"
                label="Название"
                class="mt-5"
                type="number"
                v-model="tagSort"
            />
            <Checkbox
                id="active"
                placeholder="Тег 1"
                text="Активность"
                class="mt-5"
                v-model="tagActive"
            />
            <Button
                :text="isEditMode ? 'Сохранить' : 'Создать'"
                class="relative left-[50%] mt-5 max-w-80 translate-x-[-50%] rounded-lg"
                @click="isEditMode ? updateTag() : createTag()"
            />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Popup from '@/components/Popup.vue';
import type { PageResponse } from '@/types/page-response';
import Input from '@/components/Input.vue';
import Checkbox from '@/components/Checkbox.vue';
import Button from '@/components/Button.vue';
import { Tag } from '@/types';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
    layout: AdminLayout,
});

defineProps({
    auth: {
        type: Object,
        required: false,
    },
    tagsPage: {
        type: Object as () => PageResponse<Tag>,
        required: true,
    },
});

const isFormPopupOpen = ref(false);
const isEditMode = ref(false);

const tagId = ref<string | undefined>();
const tagAlias = ref('');
const tagName = ref('');
const tagSort = ref<bigint | undefined>(undefined);
const tagActive = ref(false);

const openCreateModal = () => {
    isEditMode.value = false;
    tagId.value = undefined;
    tagAlias.value = '';
    tagName.value = '';
    tagSort.value = undefined;
    tagActive.value = false;
    isFormPopupOpen.value = true;
};

const openEditModal = (tag: Tag) => {
    isEditMode.value = true;
    tagId.value = tag.id;
    tagAlias.value = tag.alias;
    tagName.value = tag.name;
    tagSort.value = tag.sort;
    tagActive.value = tag.active;
    isFormPopupOpen.value = true;
};

const createTag = () => {
    const tag = {
        alias: tagAlias.value,
        name: tagName.value,
        active: tagActive.value,
    };
    router.post('/admin/tags', tag, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            tagId.value = undefined;
            tagAlias.value = '';
            tagSort.value = undefined;
            tagName.value = '';
            tagActive.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const updateTag = () => {
    const tag = {
        alias: tagAlias.value,
        sort: tagSort.value,
        name: tagName.value,
        active: tagActive.value,
    };
    router.put(`/admin/tags/${tagId.value}`, tag, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            tagId.value = undefined;
            tagAlias.value = '';
            tagSort.value = undefined;
            tagName.value = '';
            tagActive.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const deleteTag = (tagId: string) => {
    router.delete(`/admin/tags/${tagId}`, {
        onSuccess: () => {},
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>

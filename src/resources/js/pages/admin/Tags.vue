<template>
    <Button text="Создать" class="max-w-80 mb-5 rounded-lg" @click="openCreateModal" />
    <div class="w-full overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div
            class="grid grid-cols-4 bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
            <div class="p-4">Id</div>
            <div class="p-4">Алиас</div>
            <div class="p-4">Название</div>
            <div class="p-4">Активность</div>
        </div>

        <div class="divide-y divide-gray-200 bg-white text-sm text-gray-700">
            <div v-for="tag in tags" :key="tag.id"
                 class="grid grid-cols-4 hover:bg-gray-50 transition-colors">
                <div class="p-4 font-medium text-gray-900">#{{ tag.id }}</div>
                <div class="p-4 truncate">{{ tag.alias }}</div>
                <div class="p-4 whitespace-nowrap">{{ tag.name }}</div>
                <div class="p-4">{{ tag.active }}</div>
                <div class="flex p-4 gap-2">
                    <Button text="Редактировать" class="w-fit rounded-lg bg-yellow-400 hover:bg-yellow-500"
                            @click="openEditModal(tag)" />
                    <Button text="Удалить" class="w-fit rounded-lg bg-red-400 hover:bg-red-500"
                            @click="deleteTag(tag.id)" />
                </div>
            </div>
        </div>
    </div>

    <Popup v-model:open="isFormPopupOpen" :title="isEditMode ? 'Редактировать тег' : 'Создать тег'">
        <form class="flex flex-col w-full">
            <Input id="alias" placeholder="tag-1" label="Алиас" v-model="tagAlias" />
            <Input id="name" placeholder="Тег 1" label="Название" class="mt-5" v-model="tagName" />
            <Checkbox id="active" placeholder="Тег 1" text="Активность" class="mt-5" v-model="tagActive" />
            <Button :text="isEditMode ? 'Сохранить' : 'Создать'"
                    class="relative max-w-80 mt-5 rounded-lg left-[50%] translate-x-[-50%]"
                    @click="isEditMode ? updateTag() : createTag()" />
        </form>
    </Popup>
</template>

<script setup lang="ts">
import AdminLayout from "@/components/layouts/AdminLayout.vue";
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Popup from '@/components/Popup.vue';
import { Tag } from "@/types/tag";
import Checkbox from "@/components/Checkbox.vue";
import { PageResponse } from '@/types/page-response';

defineOptions({
    layout: AdminLayout
});

defineProps({
    auth: {
        type: Object,
        required: false,
    },
    tagsPage: {
        type: Array as () => PageResponse<Tag>[],
        required: true
    },
});

const isFormPopupOpen = ref(false);
const isEditMode = ref(false);

const tagId = ref<string | null>(null);
const tagAlias = ref('');
const tagName = ref('');
const tagActive = ref(false);

const openCreateModal = () => {
    isEditMode.value = false;
    tagAlias.value = '';
    tagName.value = '';
    tagActive.value = false;
    isFormPopupOpen.value = true;
}

const openEditModal = (tag: Tag) => {
    isEditMode.value = true;
    tagId.value = tag.id;
    tagAlias.value = tag.alias;
    tagName.value = tag.name;
    tagActive.value = tag.active;
    isFormPopupOpen.value = true;
}


const createTag = () => {
    const tag = {
        alias: tagAlias.value,
        name: tagName.value,
        active: tagActive.value
    };
    router.post('/admin/tags', tag, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            tagAlias.value = '';
            tagName.value = '';
            tagActive.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

const updateTag = () => {
    const tag = {
        alias: tagAlias.value,
        name: tagName.value,
        active: tagActive.value
    };
    router.put(`/admin/tags/${tagId.value}`, tag, {
        onSuccess: () => {
            isFormPopupOpen.value = false;
            tagId.value = null;
            tagAlias.value = '';
            tagName.value = '';
            tagActive.value = false;
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

const deleteTag = (tagId: string) => {
    router.delete(`/admin/tags/${tagId}`, {
        onSuccess: () => {},
        onError: (errors) => {
            console.error(errors);
        }
    });
}
</script>

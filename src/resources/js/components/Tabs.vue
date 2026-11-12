<template>
    <div class="flex flex-1 flex-col">
        <div
            class="flex flex-row rounded-lg shadow-[0_0_25px_var(--color-secondary)]"
        >
            <button
                v-for="item in items"
                :key="item.id"
                :class="{ 'font-bold text-secondary': activeId === item.id }"
                class="flex cursor-pointer p-2"
                type="button"
                @click="activeId = item.id"
            >
                {{ item.label }}
            </button>
        </div>

        <div class="flex flex-col">
            <div
                v-for="item in items"
                :key="item.id"
                :class="
                    activeId === item.id
                        ? 'grid-rows-[1fr] opacity-100'
                        : 'grid-rows-[0fr] opacity-0'
                "
                class="grid transition-all duration-300 ease-in-out"
                @transitionend="handleTransitionEnd(item.id)"
            >
                <div :class="{ 'overflow-hidden': fullyOpenId !== item.id }">
                    <div class="flex flex-col pt-5 pb-2">
                        <slot :name="item.id" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue';

type TabItem = {
    id: string;
    label: string;
};

interface Props {
    items: TabItem[];
}

const props = defineProps<Props>();

const activeId = ref(props.items[0]?.id || '');

const fullyOpenId = ref('');

watch(activeId, () => {
    fullyOpenId.value = '';
});

const handleTransitionEnd = (itemId: string) => {
    if (activeId.value === itemId) {
        fullyOpenId.value = itemId;
    }
};
</script>

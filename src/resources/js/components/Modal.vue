<template>
    <div
        v-if="isOpen"
        class="modal"
        @mousedown.self="mouseDown = true"
        @mouseup.self="close"
    >
        <div
            :aria-labelledby="title ? titleId : undefined"
            aria-modal="true"
            class="modal__dialog"
            role="dialog"
        >
            <Button
                style-type="link"
                class="modal__close"
                aria-label="Закрыть"
                type="button"
                @click="isOpen = false"
            >
                <Icon name="close" />
            </Button>
            <h2 v-if="title" :id="titleId" class="modal__title">{{ title }}</h2>
            <div
                :class="[
                    'modal__body',
                    { 'modal__body--without-title': !title },
                ]"
            >
                <slot />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, useId } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';

defineProps<{ title?: string }>();
const isOpen = defineModel<boolean>('open', { default: false });
const titleId = `modal-title-${useId()}`;
const mouseDown = ref(false);
useBodyScrollLock(isOpen);
const close = () => {
    if (mouseDown.value) {
        isOpen.value = false;
    }

    mouseDown.value = false;
};
</script>

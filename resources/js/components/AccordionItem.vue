<template>
    <div class="accordion-item">
        <Button
            style-type="link"
            :aria-expanded="isOpen"
            class="accordion-item__button"
            type="button"
            @click="$emit('toggle')"
        >
            <span class="accordion-item__question">{{ question }}</span>
            <span :class="iconClasses">
                <svg
                    aria-hidden="true"
                    class="accordion-item__chevron"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="m6 9 6 6 6-6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>
        </Button>
        <div :class="panelClasses">
            <div class="accordion-item__panel-inner">
                <p class="accordion-item__answer"><slot /></p>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import Button from '@/components/Button.vue';

const props = defineProps<{ question: string; isOpen: boolean }>();
defineEmits<{ toggle: [] }>();
const iconClasses = computed(() => [
    'accordion-item__icon',
    { 'accordion-item__icon--open': props.isOpen },
]);
const panelClasses = computed(() => [
    'accordion-item__panel',
    { 'accordion-item__panel--open': props.isOpen },
]);
</script>

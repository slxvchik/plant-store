<template>
    <Button
        style-type="link"
        :aria-label="
            modelValue ? 'Убрать из избранного' : 'Добавить в избранное'
        "
        :aria-pressed="modelValue"
        class="favorite-button"
        type="button"
        @click.prevent="modelValue = !modelValue"
    >
        <span :class="iconClasses"><Icon name="heart" /></span>
    </Button>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';

const modelValue = defineModel<boolean>({});
const iconClasses = computed(() => [
    'favorite-button__icon',
    { 'favorite-button__icon--active': modelValue.value },
]);
</script>

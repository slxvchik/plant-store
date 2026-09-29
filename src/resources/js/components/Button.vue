<template>
    <button v-bind="attrs" :class="computedClasses">
        <slot name="before-text" />
        {{ props.text }}
        <slot name="after-text" />
    </button>
</template>

<script setup lang="ts">
import { twClassMerge } from '@/utils/twClassMerge';
import { Link } from '@inertiajs/vue3';
import { computed, useAttrs } from 'vue';

interface Props {
    styleType?: 'button' | 'link'
    text?: string
}

const props = defineProps<Props>();

defineOptions({ inheritAttrs: false });

const inputAttrs = useAttrs();

const computedClasses = computed(() => {
    const rootClasses = props.styleType === 'link'
        ? 'font-sans text-text-muted transition-colors cursor-pointer text-base duration-200 hover:text-secondary xl:text-lg'
        : 'flex font-sans w-full cursor-pointer items-center justify-center gap-1.5 rounded-full bg-primary px-4 py-2 text-base font-medium text-white transition-colors duration-200 hover:bg-primary-hover xl:text-lg';
    return twClassMerge(
        rootClasses,
        inputAttrs.class as string
    );
});

const attrs = computed(() => {
    const { class: _, ...attrsWithoutClass } = inputAttrs;
    return { ...attrsWithoutClass };
});
</script>

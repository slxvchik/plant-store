<template>
    <button v-bind="attrs" :class="computedClasses">
        <slot name="before-text" />
        {{ props.text }}
        <slot name="after-text" />
    </button>
</template>

<script setup lang="ts">
import { computed, useAttrs } from 'vue';
import { twClassMerge } from '@/utils/twClassMerge';

interface Props {
    styleType?: 'button' | 'link';
    text?: string;
    secondary?: true;
}

const props = defineProps<Props>();

defineOptions({ inheritAttrs: false });

const inputAttrs = useAttrs();

const computedClasses = computed(() => {
    let rootClasses = '';

    if (props.styleType === 'link') {
        rootClasses +=
            'font-sans transition-colors cursor-pointer text-base duration-200 xl:text-lg';
        rootClasses += props.secondary
            ? ' text-secondary hover:text-secondary-hover'
            : ' text-primary hover:text-primary-hover';
    } else {
        rootClasses +=
            'flex font-sans w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-base font-medium text-white transition-colors duration-200 xl:text-lg';
        rootClasses += props.secondary
            ? ' bg-secondary hover:bg-secondary-hover'
            : ' bg-primary hover:bg-primary-hover';
    }

    return twClassMerge(rootClasses, inputAttrs.class as string);
});

const attrs = computed(() => {
    const { class: _, ...attrsWithoutClass } = inputAttrs;

    return { ...attrsWithoutClass };
});
</script>

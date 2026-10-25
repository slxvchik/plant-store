<template>
    <component
        :is="computedType"
        :href="props.href"
        v-bind="attrs"
        :class="computedClasses"
    >
        <slot name="before-text" />
        {{ props.text }}
        <slot name="after-text" />
    </component>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, useAttrs } from 'vue';
import { twClassMerge } from '@/utils/twClassMerge';
import type { RouteDefinition } from '@/wayfinder';

interface Props {
    styleType?: 'button' | 'link';
    href: string | RouteDefinition<'get'>;
    text?: string;
    secondary?: true;
}

const props = defineProps<Props>();

defineOptions({ inheritAttrs: false });

const inputAttrs = useAttrs();

const computedType = computed(() => {
    return isExternal.value ? 'a' : Link;
});

const computedClasses = computed(() => {
    let rootClasses = '';

    if (props.styleType === 'button') {
        rootClasses +=
            'flex font-sans w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg px-4 py-2 text-base font-medium text-white transition-colors duration-200 xl:text-lg';
        rootClasses += props.secondary
            ? ' bg-secondary hover:bg-secondary-hover'
            : ' bg-primary hover:bg-primary-hover';
    } else {
        rootClasses +=
            'font-sans transition-colors cursor-pointer text-base duration-200 xl:text-lg';
        rootClasses += props.secondary
            ? ' text-secondary hover:text-secondary-hover'
            : ' text-primary hover:text-primary-hover';
    }

    return twClassMerge(rootClasses, inputAttrs.class as string);
});

const isExternal = computed(() => {
    if (!props.href) {
        return false;
    }

    if (typeof props.href === 'string') {
        return props.href
            ? props.href.startsWith('http') || props.href.startsWith('//')
            : false;
    }

    return false;
});

const attrs = computed(() => {
    const { class: _, ...attrsWithoutClass } = inputAttrs;

    return isExternal.value
        ? { target: '_blank', rel: 'noopener noreferrer', ...attrsWithoutClass }
        : { ...attrsWithoutClass };
});
</script>

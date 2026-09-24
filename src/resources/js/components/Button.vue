<template>
    <component :is="computedType" :href="props.href" v-bind="attrs" :class="computedClasses">
        <slot name="before-text" />
        {{ props.text }}
        <slot name="after-text" />
    </component>
</template>

<script setup lang="ts">
import { twClassMerge } from '@/utils/twClassMerge';
import { Link } from '@inertiajs/vue3';
import { computed, useAttrs } from 'vue';

interface ButtonProps {
    type?: 'button'
    href?: never
    text?: string
}

interface LinkProps {
    type?: 'a'
    href: string
    text?: string
}

type Props = ButtonProps | LinkProps;

const props = defineProps<Props>();

defineOptions({ inheritAttrs: false });

const inputAttrs = useAttrs();

const computedType = computed(() => {
    if (props.type === 'button' || !props.href) return 'button'
    return isExternal.value ? 'a' : Link;
})

const computedClasses = computed(() => {
    return twClassMerge(
        'flex font-sans w-full cursor-pointer items-center justify-center gap-1.5 rounded-full bg-primary px-4 py-2 text-base font-medium text-white transition-colors duration-200 hover:bg-primary-hover xl:text-lg',
        inputAttrs.class as string
    );
});

const isExternal = computed(() => {
    return props.href ? props.href.startsWith('http') || props.href.startsWith('//') : false;
})

const isButton = computed(() => {
    return props.type === 'button' || !props.href;
})

const isLink = computed(() => {
    return !!props.href;
})

const attrs = computed(() => {
    const { class: _, ...attrsWithoutClass } = inputAttrs;

    if (isButton.value) {
        return { type: 'button', ...attrsWithoutClass };
    }
    if (isLink.value) {
        return isExternal.value
            ? { target: '_blank', rel: 'noopener noreferrer', ...attrsWithoutClass }
            : { ...attrsWithoutClass };
    }
    return { ...attrsWithoutClass };
});
</script>
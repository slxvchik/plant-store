<template>
    <component :is="computedType" :href="props.href" v-bind="attrs" :class="computedClasses">
        <slot name="before-text" />
        {{ props.text }}
        <slot name="after-text" />
    </component>
</template>

<script setup lang="ts">
import { twClassMerge } from '@/utils/twClassMerge'
import { Link } from '@inertiajs/vue3'
import { computed, useAttrs } from 'vue'

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

const computedType = computed(() => {
    if (props.type === 'button' || !props.href) return 'button';
    return isExternal.value ? 'a' : Link;
})

const inputAttrs = useAttrs();

const computedClasses = computed(() => {
    return twClassMerge(
        'font-sans text-text-muted transition-colors cursor-pointer text-base duration-200 hover:text-secondary xl:text-lg',
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
    if (isButton.value) {
        return { type: 'button' };
    }
    if (isLink.value) {
        return isExternal.value
            ? { target: '_blank', rel: 'noopener noreferrer' }
            : {};
    }
    return {};
});
</script>

<script lang="ts">
export default {
    inheritAttrs: false
}
</script>
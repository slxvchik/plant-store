<template>
    <component
        :is="external ? 'a' : InertiaLink"
        :class="[
            'link',
            `link--${styleType}`,
            { 'link--secondary': secondary, 'link--auto': autoWidth },
        ]"
        :href="href"
        v-bind="attrs"
    >
        <slot name="before-text" />
        {{ text }}
        <slot />
        <slot name="after-text" />
    </component>
</template>

<script lang="ts" setup>
import { Link as InertiaLink } from '@inertiajs/vue3';
import { computed, useAttrs } from 'vue';
import type { RouteDefinition } from '@/wayfinder';

const props = withDefaults(
    defineProps<{
        styleType?: 'button' | 'link';
        href: string | RouteDefinition<'get'>;
        text?: string;
        secondary?: boolean;
        autoWidth?: boolean;
    }>(),
    { styleType: 'link', text: '' },
);
defineOptions({ inheritAttrs: false });
const inputAttrs = useAttrs();
const external = computed(
    () => typeof props.href === 'string' && /^(https?:)?\/\//.test(props.href),
);
const attrs = computed(() => {
    const { class: _, ...attrsWithoutClass } = inputAttrs;

    return external.value
        ? { target: '_blank', rel: 'noopener noreferrer', ...attrsWithoutClass }
        : attrsWithoutClass;
});
</script>

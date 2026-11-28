<template>
    <div
        ref="element"
        :class="[
            'reveal',
            `reveal--${direction}`,
            { 'reveal--visible': visible },
        ]"
        :style="{ transitionDelay: `${delay}ms` }"
    >
        <slot />
    </div>
</template>

<script lang="ts" setup>
import { onMounted, onUnmounted, ref } from 'vue';

const props = withDefaults(
    defineProps<{
        delay?: number;
        direction?: 'up' | 'left' | 'right' | 'none';
        once?: boolean;
    }>(),
    { delay: 0, direction: 'up', once: true },
);
const element = ref<HTMLElement | null>(null);
const visible = ref(false);
let observer: IntersectionObserver | null = null;
onMounted(() => {
    if (
        !element.value ||
        window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ) {
        visible.value = true;

        return;
    }

    observer = new IntersectionObserver(
        ([entry]) => {
            if (!entry) {
                return;
            }

            visible.value = entry.isIntersecting;

            if (entry.isIntersecting && props.once) {
                observer?.disconnect();
            }
        },
        { threshold: 0.12, rootMargin: '0px 0px -32px' },
    );
    observer.observe(element.value);
});
onUnmounted(() => observer?.disconnect());
</script>

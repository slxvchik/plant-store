<template>
    <div
        ref="element"
        :class="[
            visible ? 'translate-x-0 translate-y-0 opacity-100' : hiddenClasses,
        ]"
        :style="{ transitionDelay: `${delay}ms` }"
        class="transform-gpu transition-all duration-700 ease-out will-change-transform"
    >
        <slot />
    </div>
</template>

<script lang="ts" setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

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

const hiddenClasses = computed(
    () =>
        ({
            up: 'translate-y-8 opacity-0',
            left: '-translate-x-8 opacity-0',
            right: 'translate-x-8 opacity-0',
            none: 'opacity-0',
        })[props.direction],
);

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

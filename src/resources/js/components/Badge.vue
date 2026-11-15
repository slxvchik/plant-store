<template>
    <span :class="['badge', `badge--${resolvedTone}`]">
        <span class="badge__dot" />
        {{ label }}
    </span>
</template>

<script lang="ts" setup>
import { computed } from 'vue';

type BadgeTone = 'auto' | 'success' | 'neutral' | 'warning' | 'danger' | 'info';
const props = withDefaults(defineProps<{ label: string; tone?: BadgeTone }>(), {
    tone: 'auto',
});
const palette = [
    'success',
    'info',
    'violet',
    'warning',
    'danger',
    'cyan',
] as const;
const resolvedTone = computed(() => {
    if (props.tone !== 'auto') {
        return props.tone;
    }

    const hash = [...props.label].reduce(
        (total, character) => total + character.charCodeAt(0),
        0,
    );

    return palette[hash % palette.length];
});
</script>

<template>
    <span
        :class="classes"
        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset"
    >
        <span class="h-1.5 w-1.5 rounded-full bg-current opacity-70" />
        {{ label }}
    </span>
</template>

<script lang="ts" setup>
import { computed } from 'vue';

type BadgeTone = 'auto' | 'success' | 'neutral' | 'warning' | 'danger' | 'info';

const props = withDefaults(
    defineProps<{
        label: string;
        tone?: BadgeTone;
    }>(),
    { tone: 'auto' },
);
const palette = [
    'bg-emerald-50 text-emerald-700 ring-emerald-200',
    'bg-sky-50 text-sky-700 ring-sky-200',
    'bg-violet-50 text-violet-700 ring-violet-200',
    'bg-amber-50 text-amber-700 ring-amber-200',
    'bg-rose-50 text-rose-700 ring-rose-200',
    'bg-cyan-50 text-cyan-700 ring-cyan-200',
];
const tones: Record<Exclude<BadgeTone, 'auto'>, string> = {
    success: 'bg-emerald-50 text-emerald-700 ring-emerald-200',
    neutral: 'bg-slate-100 text-slate-500 ring-slate-200',
    warning: 'bg-amber-50 text-amber-700 ring-amber-200',
    danger: 'bg-rose-50 text-rose-700 ring-rose-200',
    info: 'bg-sky-50 text-sky-700 ring-sky-200',
};
const classes = computed(() => {
    if (props.tone !== 'auto') {
        return tones[props.tone];
    }

    const hash = [...props.label].reduce(
        (total, character) => total + character.charCodeAt(0),
        0,
    );

    return palette[hash % palette.length];
});
</script>

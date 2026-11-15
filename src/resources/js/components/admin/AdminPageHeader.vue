<template>
    <div
        class="flex flex-col gap-5 border-b border-slate-200 pb-6 sm:flex-row sm:items-end sm:justify-between"
    >
        <div class="min-w-0">
            <Link
                v-if="backUrl"
                :href="backUrl"
                class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-emerald-700"
            >
                <svg
                    aria-hidden="true"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 20 20"
                >
                    <path
                        d="M12.5 15 7.5 10l5-5M8 10h9"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                    />
                </svg>
                {{ backLabel }}
            </Link>
            <p
                v-if="eyebrow"
                class="mb-1 text-xs font-semibold tracking-[0.18em] text-emerald-700 uppercase"
            >
                {{ eyebrow }}
            </p>
            <h1
                class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl"
            >
                {{ title }}
            </h1>
            <p
                v-if="description"
                class="mt-2 max-w-3xl text-sm leading-6 text-slate-500"
            >
                {{ description }}
            </p>
        </div>
        <div
            v-if="$slots.actions"
            class="flex shrink-0 flex-wrap items-center gap-3"
        >
            <slot name="actions" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        title: string;
        description?: string;
        eyebrow?: string;
        backUrl?: string;
        backLabel?: string;
    }>(),
    {
        description: '',
        eyebrow: '',
        backUrl: '',
        backLabel: 'Назад к списку',
    },
);
</script>

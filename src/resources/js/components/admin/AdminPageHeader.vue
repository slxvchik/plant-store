<template>
    <div class="admin-page-header">
        <div class="admin-page-header__content">
            <Link
                v-if="backUrl"
                :href="backUrl"
                class="admin-page-header__back"
            >
                <svg
                    aria-hidden="true"
                    class="admin-page-header__back-icon"
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
            <p v-if="eyebrow" class="admin-page-header__eyebrow">
                {{ eyebrow }}
            </p>
            <h1 class="admin-page-header__title">{{ title }}</h1>
            <p v-if="description" class="admin-page-header__description">
                {{ description }}
            </p>
        </div>
        <div v-if="$slots.actions" class="admin-page-header__actions">
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

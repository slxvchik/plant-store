<template>
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <template v-for="(item, index) in items" :key="item.url">
            <span v-if="index" class="breadcrumbs__separator">—</span>
            <span
                v-if="index === items.length - 1"
                class="breadcrumbs__item breadcrumbs__item--current"
            >
                {{ item.name }}
            </span>
            <Link v-else :href="item.url" class="breadcrumbs__item">
                {{ item.name }}
            </Link>
        </template>
    </nav>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'
import type { BreadcrumbsItem } from '@/types/breadcrumbs';

defineProps<{ items: BreadcrumbsItem[] }>();
</script>

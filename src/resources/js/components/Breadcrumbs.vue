<template>
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
        <template v-for="(item, index) in items" :key="item.url">
            <span v-if="index" class="breadcrumbs__separator">/</span>
            <span
                v-if="index === items.length - 1"
                class="breadcrumbs__current"
            >
                {{ item.name }}
            </span>
            <Link v-else :href="item.url" :text="item.name" />
        </template>
    </nav>
</template>

<script lang="ts" setup>
import Link from '@/components/Link.vue';
import type { BreadcrumbsItem } from '@/types/breadcrumbs';

defineProps<{ items: BreadcrumbsItem[] }>();
</script>

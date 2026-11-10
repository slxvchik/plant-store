<template>
    <nav
        class="flex items-center gap-2 text-xs text-text-muted dark:text-white/40"
        aria-label="Хлебные крошки"
    >
        <template v-for="(item, index) in items" :key="item.url">
            <span v-if="index !== 0 && index < items.length">/</span>
            <span
                class="text-text-title dark:text-white/65"
                v-if="item.url === currentUrl"
            >
                Каталог
            </span>
            <Link v-else :href="item.url" :text="item.name" />
        </template>
    </nav>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Link from '@/components/Link.vue';
import type { BreadcrumbsItem } from '@/types/breadcrumbs.ts';

defineProps<{
    items: BreadcrumbsItem[];
}>();

const page = usePage();
const currentUrl = computed(() => page.url);
</script>

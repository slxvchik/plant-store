<template>
    <div class="flex h-8 w-full items-center justify-center gap-2" v-if="pagination.totalPages > 1">
        <Link
            v-if="pagination.firstUrl && pagination.currentPage > 3"
            :href="pagination.firstUrl"
            :class="linkClasses"
        >
            1
        </Link>
        <span
            v-if="pagination.firstUrl && pagination.currentPage > 4"
            class="text-primary select-none"
        >
            ...
        </span>
        <template v-for="page in visiblePages" :key="page.number.toString()">
            <div v-if="page.isActive" :class="linkActiveClasses">
                {{ page.number }}
            </div>
            <Link v-else-if="page.url" :href="page.url" :class="linkClasses">
                {{ page.number }}
            </Link>
        </template>
        <span
            v-if="
                pagination.lastUrl &&
                pagination.currentPage < pagination.totalPages - 3
            "
            class="text-primary select-none"
        >
            ...
        </span>
        <Link
            v-if="
                pagination.lastUrl &&
                pagination.currentPage < pagination.totalPages - 2
            "
            :href="pagination.lastUrl"
            :class="linkClasses"
        >
            {{ pagination.totalPages }}
        </Link>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { Pagination } from '@/types/page-response.ts';

const props = defineProps({
    pagination: {
        type: Object as () => Pagination,
        required: true,
    },
});

const visiblePages = computed(() => {
    const pages = [];
    const p = props.pagination;
    const current = p.currentPage;

    if (p.prev2Url && current > 2) {
        pages.push({
            number: current - 2,
            url: p.prev2Url,
            isActive: false,
        });
    }

    if (p.prevUrl && current > 1) {
        pages.push({
            number: current - 1,
            url: p.prevUrl,
            isActive: false,
        });
    }

    pages.push({ number: current, url: null, isActive: true });

    if (p.nextUrl && current < p.totalPages) {
        pages.push({
            number: current + 1,
            url: p.nextUrl,
            isActive: false,
        });
    }

    if (p.next2Url && current + 1 < p.totalPages) {
        pages.push({
            number: current + 2,
            url: p.next2Url,
            isActive: false,
        });
    }

    return pages;
});

const linkCommonClasses =
    'flex h-8 w-8 items-center justify-center rounded-lg text-white transition-colors duration-300 select-none';
const linkClasses =
    linkCommonClasses + ' cursor-pointer bg-primary hover:bg-primary-hover';
const linkActiveClasses = linkCommonClasses + ' bg-secondary hover:none';
</script>

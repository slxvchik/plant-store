<template>
    <nav
        v-if="pagination.totalPages > 1"
        :class="['pagination', `pagination--${variant}`]"
        aria-label="Пагинация"
    >
        <template v-if="variant === 'admin'">
            <p class="pagination__summary">
                Страница
                <span class="pagination__current">
                    {{ pagination.currentPage }}
                </span>
                из {{ pagination.totalPages }}
            </p>
            <div class="pagination__actions">
                <Link
                    v-if="pagination.prevUrl"
                    :href="pagination.prevUrl"
                    class="pagination__button"
                    preserve-scroll
                >
                    Назад
                </Link>
                <span
                    v-else
                    class="pagination__button pagination__button--disabled"
                >
                    Назад
                </span>
                <Link
                    v-if="pagination.nextUrl"
                    :href="pagination.nextUrl"
                    class="pagination__button"
                    preserve-scroll
                >
                    Вперёд
                </Link>
                <span
                    v-else
                    class="pagination__button pagination__button--disabled"
                >
                    Вперёд
                </span>
            </div>
        </template>
        <template v-else>
            <Link
                v-if="pagination.firstUrl && pagination.currentPage > 3"
                :href="pagination.firstUrl"
                class="pagination__number"
            >
                1
            </Link>
            <span
                v-if="pagination.firstUrl && pagination.currentPage > 4"
                class="pagination__ellipsis"
            >
                ...
            </span>
            <template v-for="page in visiblePages" :key="page.number">
                <span
                    v-if="page.active"
                    class="pagination__number pagination__number--active"
                >
                    {{ page.number }}
                </span>
                <Link
                    v-else-if="page.url"
                    :href="page.url"
                    class="pagination__number"
                >
                    {{ page.number }}
                </Link>
            </template>
            <span
                v-if="
                    pagination.lastUrl &&
                    pagination.currentPage < pagination.totalPages - 3
                "
                class="pagination__ellipsis"
            >
                ...
            </span>
            <Link
                v-if="
                    pagination.lastUrl &&
                    pagination.currentPage < pagination.totalPages - 2
                "
                :href="pagination.lastUrl"
                class="pagination__number"
            >
                {{ pagination.totalPages }}
            </Link>
        </template>
    </nav>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { Page } from '@/types/pagination';

const props = withDefaults(
    defineProps<{
        pagination: Omit<Page<unknown>, 'items' | 'perPage'>;
        variant?: 'numbered' | 'admin';
    }>(),
    { variant: 'admin' },
);
const visiblePages = computed(() => {
    const p = props.pagination;

    return [
        { number: p.currentPage - 2, url: p.prev2Url, show: p.currentPage > 2 },
        { number: p.currentPage - 1, url: p.prevUrl, show: p.currentPage > 1 },
        { number: p.currentPage, url: null, active: true, show: true },
        {
            number: p.currentPage + 1,
            url: p.nextUrl,
            show: p.currentPage < p.totalPages,
        },
        {
            number: p.currentPage + 2,
            url: p.next2Url,
            show: p.currentPage + 1 < p.totalPages,
        },
    ].filter((page) => page.show);
});
</script>

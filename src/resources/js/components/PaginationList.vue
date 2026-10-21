<template>
    <div class="flex h-10 w-full justify-center gap-2">
        <div
            class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg bg-primary text-white transition-colors duration-300 select-none hover:bg-primary-hover"
            v-for="n in 6"
            :key="n"
        >
            {{ n }}
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Pagination } from '@/types/page-response.ts';

defineProps({
    pageResponse: {
        type: Object as () => Pagination,
        required: false,
        default: () => ({
            currentPage: BigInt(1),
            totalPages: BigInt(1),
            perPage: BigInt(1),
            prevUrl: 'string1',
            prev2Url: 'string2',
            nextUrl: 'string3',
            next2Url: 'string4',
            firstUrl: 'string5',
            lastUrl: 'string6',
        }),
    },
});
</script>

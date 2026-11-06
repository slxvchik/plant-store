<template>
    <div
        class="[&:not(:last-of-type)]:border-b border-text-title/10 dark:border-white/10"
    >
        <button
            type="button"
            class="flex min-h-14 w-full cursor-pointer items-center justify-between gap-4 py-4 text-left text-text-title transition-all duration-300 ease-in-out hover:text-primary dark:text-linen dark:hover:text-secondary"
            :aria-expanded="isOpen"
            @click="$emit('toggle')"
        >
            <span class="font-medium md:text-lg">{{ question }}</span>
            <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-bg-surface transition-all duration-300 dark:bg-white/10"
                :class="isOpen ? 'rotate-180 bg-sage-soft dark:bg-primary' : ''"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    class="h-4 w-4"
                    aria-hidden="true"
                >
                    <path
                        d="m6 9 6 6 6-6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>
        </button>
        <div
            class="grid transition-all duration-500 ease-in-out"
            :class="
                isOpen
                    ? 'grid-rows-[1fr] opacity-100'
                    : 'grid-rows-[0fr] opacity-0'
            "
        >
            <div class="overflow-hidden">
                <p
                    class="max-w-2xl pb-5 text-sm leading-7 text-text-muted md:text-base dark:text-white/60"
                >
                    <slot />
                </p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{ question: string; isOpen: boolean }>();
defineEmits<{ toggle: [] }>();
</script>

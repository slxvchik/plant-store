<template>
    <svg
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.7"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
        class="h-full w-full"
    >
        <path
            v-if="name === 'home'"
            d="m3 11 9-8 9 8v9a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"
        />
        <path
            v-else-if="name === 'catalog'"
            d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5zM4 5.5v14A1.5 1.5 0 0 0 5.5 21H20"
        />
        <path
            v-else-if="name === 'cart'"
            d="M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L21 7H6M10 21h.01M17 21h.01"
        />
        <path
            v-else-if="name === 'user'"
            d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10"
        />
        <path
            v-else-if="name === 'search'"
            d="m21 21-4.35-4.35M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0"
        />
        <path v-else-if="name === 'filter'" d="M4 6h16M7 12h10M10 18h4" />
        <path v-else-if="name === 'close'" d="M18 6 6 18M6 6l12 12" />
        <path v-else-if="name === 'chevron'" d="m9 18 6-6-6-6" />
        <path v-else-if="name === 'arrow'" d="M5 12h14m-6-6 6 6-6 6" />
        <path
            v-else-if="name === 'sun'"
            d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0"
        />
        <path
            v-else-if="name === 'moon'"
            d="M20.5 14.2A8.5 8.5 0 0 1 9.8 3.5 8.5 8.5 0 1 0 20.5 14.2"
        />
        <path
            v-else-if="name === 'heart'"
            d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8"
        />
        <path
            v-else-if="name === 'leaf'"
            d="M11 20A7 7 0 0 1 4 13c0-5 4-9 16-10 0 12-4 16-9 16M4 21c3-6 7-10 12-13"
        />
        <path v-else-if="name === 'check'" d="m5 12 4 4L19 6" />
        <path v-else-if="name === 'plus'" d="M12 5v14M5 12h14" />
        <path v-else-if="name === 'minus'" d="M5 12h14" />
        <path
            v-else-if="name === 'truck'"
            d="M10 17h4V5H2v12h3m9-7h4l4 4v3h-3M9 19a2 2 0 1 1-4 0 2 2 0 0 1 4 0m11 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0"
        />
        <path
            v-else-if="name === 'shield'"
            d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10m-4-10 3 3 5-6"
        />
        <path
            v-else-if="name === 'phone'"
            d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.8.7a2 2 0 0 1 1.7 2"
        />
        <path
            v-else-if="name === 'mail'"
            d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2m18 2-10 7L2 6"
        />
        <path
            v-else-if="name === 'pin'"
            d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0M15 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0"
        />
        <path
            v-else-if="name === 'clock'"
            d="M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0M12 6v6l4 2"
        />
        <path v-else-if="name === 'menu'" d="M4 6h16M4 12h16M4 18h16" />
        <path v-else d="M12 3v18M3 12h18" />
    </svg>
</template>

<script setup lang="ts">
defineProps<{
    name:
        | 'home'
        | 'catalog'
        | 'cart'
        | 'user'
        | 'search'
        | 'filter'
        | 'close'
        | 'chevron'
        | 'arrow'
        | 'sun'
        | 'moon'
        | 'heart'
        | 'leaf'
        | 'check'
        | 'plus'
        | 'minus'
        | 'truck'
        | 'shield'
        | 'phone'
        | 'mail'
        | 'pin'
        | 'clock'
        | 'menu';
}>();
</script>

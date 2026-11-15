<template>
    <svg
        class="icon"
        :fill="filled ? 'currentColor' : 'none'"
        :viewBox="viewBox"
        aria-hidden="true"
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="1.7"
    >
        <path
            v-for="path in paths[name]"
            :key="path"
            :clip-rule="name === 'cross' ? 'evenodd' : undefined"
            :d="path"
            :fill-rule="name === 'cross' ? 'evenodd' : undefined"
        />
    </svg>
</template>

<script lang="ts" setup>
import { computed } from 'vue';

type IconName =
    | 'home'
    | 'catalog'
    | 'cart'
    | 'user'
    | 'search'
    | 'filter'
    | 'close'
    | 'chevron'
    | 'big-chevron'
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
    | 'cross'
    | 'menu'
    | 'trash';
const props = defineProps<{ name: IconName }>();
const paths: Record<IconName, string[]> = {
    home: ['m3 11 9-8 9 8v9a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z'],
    catalog: [
        'M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5zM4 5.5v14A1.5 1.5 0 0 0 5.5 21H20',
    ],
    cart: [
        'M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L21 7H6M10 21h.01M17 21h.01',
    ],
    user: ['M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10'],
    search: ['m21 21-4.35-4.35M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0'],
    filter: ['M4 6h16M7 12h10M10 18h4'],
    close: ['M18 6 6 18M6 6l12 12'],
    chevron: ['m9 18 6-6-6-6'],
    'big-chevron': [
        'M0.38 20.08a.9.9 0 0 1 0-1.28l8.82-8.52L.38 1.46A.9.9 0 0 1 1.36.48l9.08 9.07a1.03 1.03 0 0 1 0 1.46l-9.08 9.07a.9.9 0 0 1-.98 0Z',
    ],
    arrow: ['M5 12h14m-6-6 6 6-6 6'],
    sun: [
        'M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0',
    ],
    moon: ['M20.5 14.2A8.5 8.5 0 0 1 9.8 3.5 8.5 8.5 0 1 0 20.5 14.2'],
    heart: [
        'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8',
    ],
    leaf: [
        'M11 20A7 7 0 0 1 4 13c0-5 4-9 16-10 0 12-4 16-9 16M4 21c3-6 7-10 12-13',
    ],
    check: ['m5 12 4 4L19 6'],
    plus: ['M12 5v14M5 12h14'],
    minus: ['M5 12h14'],
    truck: [
        'M10 17h4V5H2v12h3m9-7h4l4 4v3h-3M9 19a2 2 0 1 1-4 0 2 2 0 0 1 4 0m11 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0',
    ],
    shield: ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10m-4-10 3 3 5-6'],
    phone: [
        'M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.8.7a2 2 0 0 1 1.7 2',
    ],
    mail: [
        'M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2m18 2-10 7L2 6',
    ],
    pin: [
        'M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0M15 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0',
    ],
    clock: ['M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0M12 6v6l4 2'],
    cross: [
        'M4.29 4.29a1 1 0 0 1 1.42 0L10 8.59l4.29-4.3a1 1 0 1 1 1.42 1.42L11.41 10l4.3 4.29a1 1 0 0 1-1.42 1.42L10 11.41l-4.29 4.3a1 1 0 0 1-1.42-1.42L8.59 10l-4.3-4.29a1 1 0 0 1 0-1.42Z',
    ],
    menu: ['M4 6h16M4 12h16M4 18h16'],
    trash: ['M3 6h18M8 6V4h8v2m-9 0 1 15h8l1-15M10 10v7m4-7v7'],
};
const filled = computed(() =>
    ['big-chevron', 'heart', 'cross'].includes(props.name),
);
const viewBox = computed(() => {
    switch (props.name) {
        case 'big-chevron':
            return '0 0 11 20';
        case 'cross':
            return '0 0 20 20';
        default:
            return '0 0 24 24';
    }
});
</script>

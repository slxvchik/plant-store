<template>
    <button
        :class="[
            'button',
            `button--${styleType}`,
            danger
                ? 'button--danger'
                : secondary
                  ? 'button--secondary'
                  : styleType === 'button'
                    ? 'button--primary'
                    : '',
            {
                'button--ghost': ghost,
                'button--outline': outline,
                'button--sm': small,
                'button--auto': autoWidth,
            },
        ]"
    >
        <slot name="before-text" />
        {{ text }}
        <slot />
        <slot name="after-text" />
    </button>
</template>

<script lang="ts" setup>
withDefaults(
    defineProps<{
        styleType?: 'button' | 'link' | 'unstyled';
        text?: string;
        secondary?: boolean;
        danger?: boolean;
        ghost?: boolean;
        outline?: boolean;
        small?: boolean;
        autoWidth?: boolean;
    }>(),
    { styleType: 'button', text: '' },
);
</script>

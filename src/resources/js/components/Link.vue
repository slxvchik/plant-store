<template>
    <component :is="computedType" :href="props.href" v-bind="attrs"
        class="font-sans text-muted transition-colors cursor-pointer text-base duration-200 hover:text-muted-hover xl:text-lg">
        <slot name="before-text" />
        {{ props.text }}
        <slot name="after-text" />
    </component>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface ButtonProps {
    type?: 'button'
    href?: never
    text?: string
}

interface LinkProps {
    type?: 'a'
    href: string
    text?: string
}

type Props = ButtonProps | LinkProps

const props = defineProps<Props>()

const computedType = computed(() => props.type ?? (props.href ? 'a' : 'button'))

const isExternal = computed(() => {
    return props.href ? props.href.startsWith('http') || props.href.startsWith('//') : false
})

const isButton = computed(() => {
    return computedType.value === 'button'
})

const isLink = computed(() => {
    return computedType.value === 'a'
})

const attrs = computed(() => {
    if (isButton) {
        return { type: 'button' }
    }
    if (isLink) {
        return isExternal.value
            ? { target: '_blank', rel: 'noopener noreferrer' }
            : {}
    }
    return {}
});
</script>
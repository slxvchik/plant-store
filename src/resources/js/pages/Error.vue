<template>
    {{ props.code }}
    -
    {{ props.message }}
</template>

<script setup lang="ts">
const props = defineProps({
    'code': {
        type: Number,
        required: true
    },
    'message': {
        type: String,
        required: true
    }
})
</script>
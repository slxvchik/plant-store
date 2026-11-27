<template>
    <form class="admin-filter-bar" @submit.prevent="emit('submit')">
        <div class="admin-filter-bar__fields">
            <slot />
        </div>
        <div v-if="$slots.actions" class="admin-filter-bar__actions">
            <slot name="actions" />
        </div>
    </form>
</template>

<script lang="ts" setup>
const emit = defineEmits<{
    submit: [];
}>();
</script>

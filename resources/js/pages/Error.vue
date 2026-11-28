<template>
    <div class="error">{{ props.code }} - {{ props.message }}</div>
</template>
<script lang="ts" setup>
const props = defineProps({
    code: { type: Number, required: true },
    message: { type: String, required: true },
});
</script>

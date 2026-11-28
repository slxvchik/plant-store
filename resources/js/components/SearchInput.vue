<template>
    <label class="search-input">
        <span class="search-input__sr">Поиск по каталогу</span>
        <span class="search-input__icon"><Icon name="search" /></span>
        <input
            :id="id"
            v-model="searchQuery"
            class="search-input__field"
            placeholder="Название или сорт растения"
            type="search"
        />
        <Button
            style-type="unstyled"
            v-show="searchQuery !== ''"
            aria-label="Очистить поиск"
            class="search-input__clear"
            type="button"
            @click="searchQuery = ''"
        >
            <Icon name="cross" />
        </Button>
    </label>
</template>

<script lang="ts" setup>
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';

const searchQuery = defineModel<string>({ default: '' });
defineProps<{ id: string }>();
</script>

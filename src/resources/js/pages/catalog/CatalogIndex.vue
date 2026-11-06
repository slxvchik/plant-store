<template>
    <div class="py-10">
        <div class="flex flex-row justify-between">
            <input
                type="search"
                class="h-11 w-full max-w-200 rounded-lg border border-red-400 p-4"
            />
            <div class="w-full max-w-80">
                <Select :items="sortItems" v-model="productsSort" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Layout from '@/components/layouts/Layout.vue';
import Select from '@/components/Select.vue';

defineOptions({ layout: Layout });

const sortItems = [
    { label: 'Популярное', value: 'popularity' },
    { label: 'По дате поступления', value: 'date' },
    { label: 'По цене (по возрастанию)', value: 'price-big' },
    { label: 'По цене (по убыванию)', value: 'price-small' },
];

const productsSort = ref('popularity');
</script>

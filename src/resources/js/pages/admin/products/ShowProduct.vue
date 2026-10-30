<template>
    <div class="flex flex-col gap-5">
        <div class="w-fit">
            <Link :href="AdminProduct.index.url()" text="К списку" secondary />
        </div>
        <div class="flex flex-row gap-10">
            <h1 class="text-4xl text-text-title">Просмотр товара товара</h1>
            <h2 class="text-2xl text-text-title">{{ product.name }}</h2>
        </div>
        <Tabs :items="tabs">
            <template #product>
                <div class="flex flex-col gap-5">
                    <p>#{{ product.id }}</p>
                    <p>{{ product.name }}</p>
                    <p>{{ product.active }}</p>
                    <p>{{ product.alias }}</p>
                    <p>{{ product.categories }}</p>
                </div>
            </template>
            <template #offers>
                <div class="flex flex-col gap-5">TP</div>
            </template>
        </Tabs>
    </div>
</template>

<script setup lang="ts">
import AdminLayout from '@/components/layouts/AdminLayout.vue';
import Link from '@/components/Link.vue';
import Tabs from '@/components/Tabs.vue';
import AdminProduct from '@/routes/admin/products';
import type { Product } from '@/types/product.ts';
import { onMounted } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    product: Product;
}>();

const tabs = [
    { id: 'product', label: 'Товар' },
    { id: 'offers', label: 'Торговые предложения' },
];

onMounted(() => {
    console.log(props);
});
</script>

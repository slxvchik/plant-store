<template>
    <HeroSlider />
    <OftenBoughtProducts />
    <Blog />
    <Callback />
    <OurMission />
</template>

<script setup lang="ts">
import Layout from '@/components/layouts/Layout.vue';
import Blog from '@/components/Blog.vue';
import Callback from '@/components/Callback.vue';
import HeroSlider from '@/components/HeroSlider.vue';
import OftenBoughtProducts from '@/components/OftenBoughtProducts.vue';
import OurMission from '@/components/OurMission.vue';

defineOptions({
    layout: Layout,
});
</script>

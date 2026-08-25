<template>
    <HeroSlider />
    <OftenBoughtProducts />
    <Blog />
    <Callback />
    <OurMission />
</template>

<script setup lang="ts">
import Layout from '@/components/Layout.vue';
import Blog from '@/components/pages/home/Blog.vue';
import Callback from '@/components/pages/home/Callback.vue';
import HeroSlider from '@/components/pages/home/HeroSlider.vue';
import OftenBoughtProducts from '@/components/pages/home/OftenBoughtProducts.vue';
import OurMission from '@/components/pages/home/OurMission.vue';

defineOptions({
    layout: Layout,
});
</script>

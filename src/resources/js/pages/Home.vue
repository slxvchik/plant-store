<template>
    <HeroSlider />
    <OftenBoughtProducts />
    <FeaturesBento />
    <OurMission />
    <Faq />
    <Blog v-if="false"/>
    <Callback />
</template>

<script setup lang="ts">
import Blog from '@/components/Blog.vue';
import Callback from '@/components/Callback.vue';
import Faq from '@/components/Faq.vue';
import FeaturesBento from '@/components/FeaturesBento.vue';
import HeroSlider from '@/components/HeroSlider.vue';
import Layout from '@/components/layouts/Layout.vue';
import OurMission from '@/components/OurMission.vue';
import OftenBoughtProducts from '@/components/product/OftenBoughtProducts.vue';

defineOptions({ layout: Layout });
</script>

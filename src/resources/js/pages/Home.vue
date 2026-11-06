<template>
    <HeroSlider />
    <OftenBoughtProducts />
    <FeaturesBento />
    <OurMission />
    <PricingFaq />
    <Blog />
    <Callback />
</template>

<script setup lang="ts">
import Blog from '@/components/Blog.vue';
import Callback from '@/components/Callback.vue';
import FeaturesBento from '@/components/FeaturesBento.vue';
import HeroSlider from '@/components/HeroSlider.vue';
import Layout from '@/components/layouts/Layout.vue';
import OftenBoughtProducts from '@/components/OftenBoughtProducts.vue';
import OurMission from '@/components/OurMission.vue';
import PricingFaq from '@/components/PricingFaq.vue';

defineOptions({ layout: Layout });
</script>

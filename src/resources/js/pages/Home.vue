<template>
    <div class="home">
        <HeroSlider />
        <OftenBoughtProducts />
        <FeaturesBento />
        <OurMission />
        <Faq />
        <Blog v-if="false" />
        <Callback />
    </div>
</template>
<script lang="ts" setup>
import Blog from '@/components/blog/Blog.vue';
import Faq from '@/components/home/Faq.vue';
import FeaturesBento from '@/components/home/FeaturesBento.vue';
import HeroSlider from '@/components/home/HeroSlider.vue';
import OurMission from '@/components/home/OurMission.vue';
import OftenBoughtProducts from '@/components/product/OftenBoughtProducts.vue';
import Callback from '@/components/public/Callback.vue';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });
</script>

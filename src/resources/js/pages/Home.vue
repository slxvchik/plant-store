<template>
    <div class="home">
        <HeroSlider />
        <OftenBoughtProducts :products="props.featuredProducts" />
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
import type { Product } from '@/types/product.ts';

defineOptions({ layout: AppLayout });

interface Props {
    featuredProducts: Product[],
}
const props = defineProps<Props>();
</script>

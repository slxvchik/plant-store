<template>
    <section class="w-full bg-bg-2 px-3 py-8 lg:px-8 lg:py-20">
        <h2 class="text font-serif font-bold text-accent uppercase">
            Наша тщательно подобранная теплица
        </h2>
        <p
            class="mt-3 font-sans text-4xl leading-[1.1] font-light whitespace-pre-line text-main sm:text-5xl lg:text-6xl"
        >
            Часто покупаемые
        </p>
        <p class="mt-3 mb-10 font-sans text-muted sm:text-lg">
            Каждый саженец отбирается по таким критериям, как здоровые корни,
            яркая листва и сбалансированный рост, и только после этого попадает
            к вам.
        </p>
        <ProductSlider />
    </section>
</template>

<script setup lang="ts">
import ProductSlider from '@/components/ProductSlider.vue';
</script>

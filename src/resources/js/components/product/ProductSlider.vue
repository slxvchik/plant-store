<template>
    <Container class="relative">
        <swiper
            :breakpoints="{
                320: { slidesPerView: 1.25 },
                540: { slidesPerView: 2 },
                768: { slidesPerView: 2.5 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 },
            }"
            :modules="swiperOptions"
            :navigation="{
                prevEl: '.product-slider-prev',
                nextEl: '.product-slider-next',
            }"
            :space-between="0"
            :watch-slides-progress="true"
            class="product-slider w-full !overflow-visible lg:!overflow-hidden"
        >
            <swiper-slide
                v-for="product in items"
                :key="product.id"
                class="h-auto px-2 py-4"
            >
                <ProductCard :product="product" />
            </swiper-slide>
        </swiper>
        <button
            aria-label="Предыдущие растения"
            class="product-slider-prev absolute top-[35%] left-0 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-text-title/10 bg-bg-elevated text-text-title shadow-lg transition-all duration-300 hover:scale-105 hover:bg-primary hover:text-white lg:flex dark:border-white/10 dark:bg-bg-night-soft dark:text-white"
            type="button"
        >
            <span class="h-5 w-5 rotate-180">
                <AppIcon name="chevron" />
            </span>
        </button>
        <button
            aria-label="Следующие растения"
            class="product-slider-next absolute top-[35%] right-0 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-text-title/10 bg-bg-elevated text-text-title shadow-lg transition-all duration-300 hover:scale-105 hover:bg-primary hover:text-white lg:flex dark:border-white/10 dark:bg-bg-night-soft dark:text-white"
            type="button"
        >
            <span class="h-5 w-5"><AppIcon name="chevron" /></span>
        </button>
    </Container>
</template>

<script lang="ts" setup>
import { Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import AppIcon from '@/components/AppIcon.vue';
import Container from '@/components/Container.vue';
import ProductCard from '@/components/product/ProductCard.vue';
import 'swiper/css';
import 'swiper/css/navigation';
import type { ProductListItem } from '@/types/product.ts';

const swiperOptions = [Navigation];
defineProps<{ items: ProductListItem[] }>();
</script>

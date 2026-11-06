<template>
    <div class="relative w-full lg:px-12">
        <swiper
            :navigation="{
                prevEl: '.product-slider-prev',
                nextEl: '.product-slider-next',
            }"
            :space-between="16"
            :breakpoints="{
                320: { slidesPerView: 1.25 },
                540: { slidesPerView: 2 },
                768: { slidesPerView: 2.5 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 },
            }"
            :modules="swiperOptions"
            class="product-slider w-full !overflow-visible lg:!overflow-hidden"
        >
            <swiper-slide
                v-for="product in storefrontProducts"
                :key="product.id"
                class="h-auto pb-8"
            >
                <ProductCard :product="product" />
            </swiper-slide>
        </swiper>
        <button
            type="button"
            class="product-slider-prev absolute top-[35%] left-0 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-text-title/10 bg-bg-elevated text-text-title shadow-lg transition-all duration-300 hover:scale-105 hover:bg-primary hover:text-white lg:flex dark:border-white/10 dark:bg-bg-night-soft dark:text-white"
            aria-label="Предыдущие растения"
        >
            <span class="h-5 w-5 rotate-180"><AppIcon name="chevron" /></span>
        </button>
        <button
            type="button"
            class="product-slider-next absolute top-[35%] right-0 z-10 hidden h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-text-title/10 bg-bg-elevated text-text-title shadow-lg transition-all duration-300 hover:scale-105 hover:bg-primary hover:text-white lg:flex dark:border-white/10 dark:bg-bg-night-soft dark:text-white"
            aria-label="Следующие растения"
        >
            <span class="h-5 w-5"><AppIcon name="chevron" /></span>
        </button>
    </div>
</template>

<script setup lang="ts">
import { Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import AppIcon from '@/components/AppIcon.vue';
import ProductCard from '@/components/product/ProductCard.vue';
import { storefrontProducts } from '@/data/products.ts';
import 'swiper/css';
import 'swiper/css/navigation';

const swiperOptions = [Navigation];
</script>

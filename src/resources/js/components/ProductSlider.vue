<template>
    <div class="relative w-full px-12">
        <swiper
            :loop="true"
            :navigation="{
                prevEl: '.product-slider-prev',
                nextEl: '.product-slider-next',
            }"
            :autoplay="{
                delay: 3000,
                disableOnInteraction: true,
            }"
            :spaceBetween="20"
            :breakpoints="{
                320: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1440: { slidesPerView: 4 },
                1920: { slidesPerView: 5 },
            }"
            :modules="swiperOptions"
            class="product-slider w-full"
        >
            <swiper-slide v-for="n in 8" :key="n" class="w-80">
                <ProductCard />
            </swiper-slide>
        </swiper>
        <div
            class="product-slider-nav absolute top-1/2 left-0 flex h-10 w-full -translate-y-1/2 flex-row justify-between"
        >
            <button
                class="product-slider-prev left-0 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-btn-light-bg text-white backdrop-blur-sm transition-all duration-300 ease-in hover:bg-btn-light-bg-hover"
            >
                <ChevronIcon class="relative right-px rotate-180" />
            </button>
            <button
                class="product-slider-next right-0 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-btn-light-bg text-white backdrop-blur-sm transition-all duration-300 ease-in hover:bg-btn-light-bg-hover"
            >
                <ChevronIcon class="relative left-px" />
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Autoplay, Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import ChevronIcon from '@/components/icons/ChevronIcon.vue';
import ProductCard from '@/components/ProductCard.vue';

import 'swiper/css';
import 'swiper/css/navigation';

const swiperOptions = [Autoplay, Navigation];
</script>

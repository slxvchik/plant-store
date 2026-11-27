<template>
    <div
        class="product-detail-slider"
    >
        <Swiper
            :effect="'fade'"
            :modules="swiperModules"
            :slides-per-view="1"
            navigation
            loop
            class="product-detail-slider__slider"
        >
            <SwiperSlide
                v-for="slide in slides" :key="slide.id"
                class="swiper-slide product-detail-slider__slide"
            >
                <img
                    :src="slide.webPathToFile"
                    :width="slide.width ?? undefined"
                    :height="slide.height ?? undefined"
                    :alt="slide.altText ?? undefined"
                    :title="slide.titleText ?? undefined"
                    class="product-detail-slider__img"
                />
            </SwiperSlide>
        </Swiper>
    </div>
</template>

<script setup lang="ts">
import { EffectFade, Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import type { Image } from '@/types';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';

interface Props {
    slides: Image[];
}
defineProps<Props>();

const swiperModules = [EffectFade, Navigation];
</script>

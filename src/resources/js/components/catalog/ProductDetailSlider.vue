<template>
    <div
        class="product-detail-slider"
    >
        <Swiper
            :effect="'fade'"
            :modules="swiperModules"
            :slides-per-view="1"
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
import { EffectFade } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import type { Image } from '@/types';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';

interface Props {
    slides: Image[];
}
defineProps<Props>();

const swiperModules = [EffectFade];
</script>

<style lang="scss">
.product-detail-slider {
    width: 100%;
    background-color: #f3f4f6;

    &__slider,
    &__slide {
        width: 100%;
        height: 100%;
        max-height: 600px;
        max-width: 600px;
        aspect-ratio: 1 / 1;
        border-radius: 12px;
        overflow: hidden;
    }

    &__img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
}
</style>

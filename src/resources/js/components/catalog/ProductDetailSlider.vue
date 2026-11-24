<template>
    <Swiper
        :effect="'fade'"
        :modules="swiperModules"
        :slides-per-view="1"
        loop
    >
        <SwiperSlide
            v-for="slide in slides" :key="slide.id"
            class="swiper-slide"
        >
            <div>
                <img
                    :src="slide.webPathToFile"
                    :width="slide.width ?? undefined"
                    :height="slide.height ?? undefined"
                    :alt="slide.altText ?? undefined"
                    :title="slide.titleText ?? undefined"
                />
            </div>
        </SwiperSlide>
    </Swiper>
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

<template>
    <section v-if="slides && slides.length > 0" class="hero-slider">
        <swiper
            :autoplay="{ delay: 65000, disableOnInteraction: false }"
            :effect="'fade'"
            :loop="true"
            :modules="swiperModules"
            :slides-per-view="1"
            :speed="900"
            class="hero-slider__swiper"
            @slide-change="onSlideChange"
        >
            <swiper-slide v-for="slide in slides" :key="slide.id">
                <div class="hero-slider__slide">
                    <div class="hero-slider__visual">
                        <img
                            :src="slide.image?.webPathToFile ?? undefined"
                            :alt="slide.image?.altText ?? undefined"
                            :title="slide.image?.titleText ?? undefined"
                            :width="slide.image?.width ?? undefined"
                            :height="slide.image?.height ?? undefined"
                            class="hero-slider__image"
                            fetchpriority="high"
                        />
                    </div>
                    <div class="hero-slider__content">
                        <div
                            class="hero-slider__decoration hero-slider__decoration--left"
                        />
                        <div
                            class="hero-slider__decoration hero-slider__decoration--right"
                        />
                        <div class="hero-slider__copy">
                            <p v-if="slide.preTitle" class="hero-slider__eyebrow">
                                <span class="hero-slider__eyebrow-icon">
                                    <Icon name="leaf" />
                                </span>
                                {{ slide.preTitle }}
                            </p>
                            <h1 class="hero-slider__title">
                                {{ slide.title }}
                            </h1>
                            <p class="hero-slider__description">
                                {{ slide.description }}
                            </p>
                            <div class="hero-slider__actions">
                                <Link v-if="slide.buttonLink && slide.buttonText"
                                    class="hero-slider__primary"
                                    :href="slide.buttonLink"
                                >
                                    {{ slide.buttonText }}
                                    <span class="hero-slider__primary-icon">
                                        <Icon name="arrow" />
                                    </span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </swiper-slide>
            <div class="hero-slider__counter">
                <span>
                    {{ addZeroNumber(activeSlide + 1) }} /
                    {{ addZeroNumber(slides.length) }}
                </span>
            </div>
        </swiper>
    </section>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import type { Swiper as SwiperInstance } from 'swiper';
import { Autoplay, EffectFade } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref } from 'vue';
import Icon from '@/components/icons/Icon.vue';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';
import type { MainPageGallerySlide } from '@/types/main-page-gallery.ts';

interface Props {
    slides: MainPageGallerySlide[];
}
const { slides } = defineProps<Props>();

const activeSlide = ref(0);
const swiperModules = [EffectFade, Autoplay];
const addZeroNumber = (num: number): string =>
    num < 10 ? `0${num}` : `${num}`;
const onSlideChange = (swiper: SwiperInstance): void => {
    activeSlide.value = swiper.realIndex;
};
</script>

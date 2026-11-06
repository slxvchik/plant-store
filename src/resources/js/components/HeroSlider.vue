<template>
    <section class="bg-bg-base px-3 pt-3 md:px-6 md:pt-6 lg:bg-bg-dark lg:p-0">
        <swiper
            :slides-per-view="1"
            :autoplay="{ delay: 6500, disableOnInteraction: false }"
            :loop="true"
            :effect="'fade'"
            :speed="900"
            :modules="swiperModules"
            class="hero-gallery relative overflow-hidden rounded-[28px] lg:rounded-none"
            @slide-change="onSlideChange"
        >
            <swiper-slide v-for="slide in slides" :key="slide.title">
                <div
                    class="grid bg-bg-elevated lg:h-[680px] lg:grid-cols-2 lg:bg-bg-dark dark:bg-bg-night-soft"
                >
                    <div
                        class="relative order-1 h-[340px] overflow-hidden md:h-[480px] lg:order-2 lg:h-full"
                    >
                        <img
                            :src="slide.image"
                            :alt="slide.imageAlt"
                            class="h-full w-full scale-105 object-cover"
                            fetchpriority="high"
                        />
                    </div>
                    <div
                        class="relative order-2 flex items-center overflow-hidden px-5 py-8 md:px-10 md:py-12 lg:order-1 lg:px-[max(3rem,calc((100vw-1440px)/2+3rem))] lg:py-20"
                    >
                        <div
                            class="pointer-events-none absolute -bottom-20 -left-24 h-72 w-72 rounded-full border border-primary/10 lg:border-white/5"
                        />
                        <div
                            class="pointer-events-none absolute -right-20 -bottom-28 h-80 w-80 rounded-full border border-primary/10 transition-transform duration-1000 lg:border-white/5"
                            :style="{
                                transform: `rotate(${activeSlide * 20}deg)`,
                            }"
                        />
                        <div class="relative z-10 max-w-xl">
                            <p
                                class="mb-4 flex items-center gap-2 text-[11px] font-semibold tracking-[0.2em] text-primary uppercase md:text-xs lg:text-secondary dark:text-secondary"
                            >
                                <span class="h-4 w-4">
                                    <AppIcon name="leaf" />
                                </span>
                                {{ slide.eyebrow }}
                            </p>
                            <h1
                                class="font-serif text-[40px] leading-[1.04] font-medium tracking-[-0.035em] text-text-title md:text-6xl lg:text-[64px] lg:text-linen xl:text-[72px] dark:text-linen"
                            >
                                {{ slide.title }}
                                <em
                                    class="font-normal text-primary lg:text-secondary"
                                    >{{ slide.accent }}</em
                                >
                            </h1>
                            <p
                                class="mt-5 max-w-md text-[15px] leading-7 text-text-muted md:text-lg md:leading-8 lg:line-clamp-7 lg:text-white/60 dark:text-white/60"
                            >
                                {{ slide.description }}
                            </p>
                            <div
                                class="mt-7 mb-4 grid grid-cols-2 gap-3 min-[420px]:flex-row md:mt-9"
                            >
                                <Link
                                    href="/catalog"
                                    class="group flex min-h-12 items-center justify-center gap-3 rounded-full bg-primary px-6 text-sm font-semibold text-white shadow-lg shadow-primary/15 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:bg-primary-hover hover:shadow-xl lg:bg-secondary lg:text-bg-dark lg:hover:bg-linen"
                                >
                                    Выбрать растение
                                    <span
                                        class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                    >
                                        <AppIcon name="arrow" />
                                    </span>
                                </Link>
                                <a
                                    href="#mission"
                                    class="flex min-h-12 items-center justify-center rounded-full border border-text-title/15 px-6 text-sm font-semibold text-text-title transition-all duration-300 hover:border-primary hover:bg-sage-soft/50 lg:border-white/20 lg:text-white lg:hover:border-white/40 lg:hover:bg-white/5 dark:text-linen"
                                    >Наша философия</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </swiper-slide>
            <div
                class="absolute bottom-5 left-[50%] z-10 flex translate-x-[-50%] items-center lg:bottom-5 lg:left-5 lg:translate-x-0"
            >
                <span
                    class="text-xs font-medium tracking-widest text-nowrap text-text-muted lg:text-white/45"
                >
                    {{ addZeroNumber(activeSlide + 1) }} /
                    {{ addZeroNumber(slides.length) }}
                </span>
            </div>
        </swiper>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { Swiper as SwiperInstance } from 'swiper';
import { Autoplay, EffectFade } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';

const activeSlide = ref(0);
const swiperModules = [EffectFade, Autoplay];
const slides = [
    {
        eyebrow: 'Питомник растений полного цикла',
        title: 'Природа, которую',
        accent: 'хочется обнять',
        description:
            'Выращиваем здоровые растения с характером и доставляем их вместе со знаниями, поддержкой и вдохновением.',
        image: '/images/slide_1.avif',
        imageAlt: 'Ухоженные растения в питомнике Деулино Сад',
        caption: 'Выращено в Деулино · 55°42′ N',
    },
    {
        eyebrow: 'Новая коллекция уже здесь',
        title: 'Ваш дом. Ваш ритм.',
        accent: 'Ваш сад',
        description:
            'От первого компактного фикуса до зелёной коллекции — подберём растения под ваш свет, пространство и образ жизни.От первого компактного фикуса до зелёной коллекции — подберём растения под ваш свет, пространство и образ жизни.От первого компактного фикуса до зелёной коллекции — подберём растения под ваш свет, пространство и образ жизни.',
        image: '/images/slide_2.avif',
        imageAlt: 'Зелёные растения в светлой оранжерее',
        caption: 'Новая весенняя коллекция',
    },
];
const addZeroNumber = (num: number): string => {
    if (num < 10) {
        return `0${num}`;
    }

    return `${num}`;
};
const onSlideChange = (swiper: SwiperInstance): void => {
    activeSlide.value = swiper.realIndex;
};
</script>

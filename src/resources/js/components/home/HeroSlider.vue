<template>
    <section class="bg-bg-base px-3 pt-3 md:bg-bg-dark md:p-0">
        <swiper
            :autoplay="{ delay: 65000, disableOnInteraction: false }"
            :effect="'fade'"
            :loop="true"
            :modules="swiperModules"
            :slides-per-view="1"
            :speed="900"
            class="relative h-[700px] overflow-hidden rounded-[28px] md:h-[680px] md:rounded-none"
            @slide-change="onSlideChange"
        >
            <swiper-slide v-for="slide in slides" :key="slide.title" class="">
                <div
                    class="flex h-full flex-col bg-bg-elevated md:grid md:grid-cols-2 md:bg-bg-dark dark:bg-bg-night-soft"
                >
                    <div
                        class="relative order-1 h-[340px] overflow-hidden md:order-2 md:h-full"
                    >
                        <img
                            :alt="slide.imageAlt"
                            :src="slide.image"
                            class="h-full w-full scale-105 object-cover"
                            fetchpriority="high"
                        />
                    </div>
                    <div
                        class="flex-start relative order-2 flex h-full grow overflow-hidden px-5 py-8 md:order-1 md:p-10 lg:p-20"
                    >
                        <div
                            class="pointer-events-none absolute -bottom-20 -left-24 h-72 w-72 rounded-full border border-primary/10 md:border-white/5"
                        />
                        <div
                            :style="{
                                transform: `rotate(${activeSlide * 20}deg)`,
                            }"
                            class="pointer-events-none absolute -right-20 -bottom-28 h-80 w-80 rounded-full border border-primary/10 transition-transform duration-1000 md:border-white/5"
                        />
                        <div class="relative z-10">
                            <p
                                class="mb-4 flex items-center gap-2 text-[11px] font-semibold tracking-[0.2em] text-primary uppercase md:text-xs md:text-secondary dark:text-secondary"
                            >
                                <span class="h-4 w-4">
                                    <AppIcon name="leaf" />
                                </span>
                                {{ slide.eyebrow }}
                            </p>
                            <h1
                                class="line-clamp-2 pb-1 pr-1 font-serif text-[40px] leading-[1.04] font-medium tracking-[-0.035em] text-text-title md:text-6xl md:text-[64px] md:text-linen xl:text-[72px] dark:text-linen"
                            >
                                {{ slide.title }}
                                <em
                                    class="font-normal text-primary md:line-clamp-none md:text-secondary lg:text-nowrap"
                                >
                                    {{ slide.accent }}
                                </em>
                            </h1>
                            <p
                                class="mt-5 line-clamp-7 max-w-md text-[15px] leading-7 text-text-muted md:text-lg md:leading-8 md:text-white/60 dark:text-white/60"
                            >
                                {{ slide.description }}
                            </p>
                            <div
                                class="mt-7 mb-4 grid grid-cols-2 gap-3 min-[420px]:flex-row md:mt-9"
                            >
                                <Link
                                    class="group flex min-h-12 items-center justify-center gap-3 rounded-full bg-primary px-6 text-sm font-semibold text-white shadow-lg shadow-primary/15 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:bg-primary-hover hover:shadow-xl md:bg-secondary md:text-bg-dark md:hover:bg-linen"
                                    href="/catalog"
                                >
                                    Выбрать растение
                                    <span
                                        class="flex h-4 w-4 shrink-0 transition-transform duration-300 group-hover:translate-x-1"
                                    >
                                        <AppIcon name="arrow" />
                                    </span>
                                </Link>
                                <a
                                    class="flex min-h-12 items-center justify-center rounded-full border border-text-title/15 px-6 text-sm font-semibold text-text-title transition-all duration-300 hover:border-primary hover:bg-sage-soft/50 md:border-white/20 md:text-white md:hover:border-white/40 md:hover:bg-white/5 dark:text-linen"
                                    href="#mission"
                                >
                                    Наша философия
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </swiper-slide>
            <div
                class="absolute bottom-5 left-[50%] z-10 flex translate-x-[-50%] items-center md:bottom-5 md:left-5 md:translate-x-0"
            >
                <span
                    class="text-xs font-medium tracking-widest text-nowrap text-text-muted md:text-white/45"
                >
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

<template>
    <section class="hero-slider">
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
            <swiper-slide v-for="slide in slides" :key="slide.title">
                <div class="hero-slider__slide">
                    <div class="hero-slider__visual">
                        <img
                            :alt="slide.imageAlt"
                            :src="slide.image"
                            class="hero-slider__image"
                            fetchpriority="high"
                        />
                    </div>
                    <div class="hero-slider__content">
                        <div
                            class="hero-slider__decoration hero-slider__decoration--left"
                        />
                        <div
                            :style="{
                                transform: `rotate(${activeSlide * 20}deg)`,
                            }"
                            class="hero-slider__decoration hero-slider__decoration--right"
                        />
                        <div class="hero-slider__copy">
                            <p class="hero-slider__eyebrow">
                                <span class="hero-slider__eyebrow-icon">
                                    <Icon name="leaf" />
                                </span>
                                {{ slide.eyebrow }}
                            </p>
                            <h1 class="hero-slider__title">
                                {{ slide.title }}
                                <em class="hero-slider__accent">
                                    {{ slide.accent }}
                                </em>
                            </h1>
                            <p class="hero-slider__description">
                                {{ slide.description }}
                            </p>
                            <div class="hero-slider__actions">
                                <Link
                                    class="hero-slider__primary"
                                    href="/catalog"
                                >
                                    Выбрать растение
                                    <span class="hero-slider__primary-icon">
                                        <Icon name="arrow" />
                                    </span>
                                </Link>
                                <a
                                    class="hero-slider__secondary"
                                    href="#mission"
                                >
                                    Наша философия
                                </a>
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
const addZeroNumber = (num: number): string =>
    num < 10 ? `0${num}` : `${num}`;
const onSlideChange = (swiper: SwiperInstance): void => {
    activeSlide.value = swiper.realIndex;
};
</script>

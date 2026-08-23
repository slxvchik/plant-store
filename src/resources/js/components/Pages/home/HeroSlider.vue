<template>
    <section>
        <swiper
            ref="heroGalleryRef"
            :slides-per-view="1"
            :autoplay="{
                delay: 3000,
                disableOnInteraction: false,
            }"
            :loop="true"
            :effect="'fade'"
            :pagination="{ clickable: true }"
            :modules="swiperModules"
            :style="{
                '--swiper-pagination-color': 'var(--color-bright)',
                '--swiper-pagination-bullet-inactive-opacity': '1',
                '--swiper-pagination-bullet-inactive-color': 'rgb(0 0 0 / 20%)',
            }"
            class="hero-gallery relative h-[60vh] min-h-140 w-full overflow-hidden md:h-[80vh]"
        >
            <swiper-slide
                v-for="n in 2"
                :key="n"
                class="relative h-full w-full px-5"
            >
                <img
                    :src="'/images/slide_' + n + '.avif'"
                    alt="Слайд 1"
                    title="Слайд 1"
                    class="absolute top-0 left-0 h-full w-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-linear-to-r from-[#0d1f07]/80 via-[#1e3d0f]/40 to-transparent"
                ></div>

                <div class="relative h-full w-full items-center pt-20">
                    <p
                        class="mb-4 inline-block cursor-default font-serif font-semibold tracking-[0.2em] text-bright uppercase transition-all"
                    >
                        Наше обещание
                    </p>
                    <h2
                        class="mb-5 cursor-default font-sans text-4xl leading-[1.1] font-light whitespace-pre-line text-white sm:text-5xl lg:text-6xl"
                    >
                        Выращено с заботой, доставлено с любовью
                    </h2>
                    <p
                        class="mb-8 max-w-sm cursor-default font-sans text-base leading-relaxed text-white/70 sm:text-lg"
                    >
                        Каждое растение выращивается в экосертифицированных
                        питомниках
                    </p>
                    <a
                        href="/catalog"
                        class="inline-flex items-center gap-2 rounded-full bg-btn-light-bg px-6 py-3 font-sans font-medium text-white transition-colors duration-200 hover:bg-btn-light-bg-hover"
                        >В каталог</a
                    >
                </div>
            </swiper-slide>
        </swiper>
    </section>
</template>

<script setup lang="ts">
import { EffectFade, Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';

import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';

const swiperModules = [EffectFade, Autoplay, Pagination];
</script>

<style>
.hero-gallery .swiper-pagination-bullet {
    transition: all 0.5s ease;
    border: 1px solid var(--color-bright);
}
.hero-gallery .swiper-pagination-bullet-active {
    width: 1.5rem;
    border-radius: 25px;
}
</style>

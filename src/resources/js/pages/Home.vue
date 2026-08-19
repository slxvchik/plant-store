<template>
    <!-- slider -->
    <section>
        <swiper
            ref="heroGalleryRef"
            :modules="swiperModules"
            :slides-per-view="1"
            :pagination="{ clickable: true }"
        >
            <swiper-slide v-for="n in 2" :key="n" class="relative w-full h-auto">
                <img
                    :src="'/images/slide_' + n + '.avif'"
                    alt="Слайд 1"
                    title="Слайд 1"
                    class="h-full w-full object-cover"
                />
                <div class="absolute top-0 left-0 h-full w-full">
                    <p>Наше обещание</p>
                    <h2>Выращено с заботой, доставлено с любовью</h2>
                    <p>
                        Каждое растение выращивается в экосертифицированных
                        питомниках
                    </p>
                    <a href="/catalog">В каталог</a>
                </div>
            </swiper-slide>
        </swiper>
    </section>
    <!-- /slider -->
</template>

<script setup lang="ts">
import { Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import Layout from '@/components/Layout.vue';

import 'swiper/css';
import 'swiper/css/pagination';

const swiperModules = [Pagination];

defineOptions({
    layout: Layout,
});
</script>

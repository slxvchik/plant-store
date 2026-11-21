<template>
    <Container class="product-slider">
        <swiper
            :breakpoints="{
                320: { slidesPerView: 1.25 },
                540: { slidesPerView: 2 },
                768: { slidesPerView: 2.5 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 },
            }"
            :modules="swiperOptions"
            :navigation="{
                prevEl: '.product-slider-prev',
                nextEl: '.product-slider-next',
            }"
            :space-between="0"
            :watch-slides-progress="true"
            class="product-slider__swiper"
        >
            <swiper-slide
                v-for="product in items"
                :key="product.id"
                class="product-slider__slide"
            >
                <ProductCard :product="product" />
            </swiper-slide>
        </swiper>
        <Button
            class="product-slider__button product-slider__button--previous product-slider-prev"
            aria-label="Предыдущие растения"
            style-type="link"
            type="button"
        >
            <span class="product-slider__icon product-slider__icon--previous">
                <Icon name="chevron" />
            </span>
        </Button>
        <Button
            class="product-slider__button product-slider__button--next product-slider-next"
            aria-label="Следующие растения"
            style-type="link"
            type="button"
        >
            <span class="product-slider__icon"><Icon name="chevron" /></span>
        </Button>
    </Container>
</template>
<script lang="ts" setup>
import { Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import Button from '@/components/Button.vue';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import ProductCard from '@/components/product/ProductCard.vue';
import 'swiper/css';
import 'swiper/css/navigation';
import type { Product } from '@/types/product.ts';

const swiperOptions = [Navigation];
defineProps<{ items: Product[] }>();
</script>

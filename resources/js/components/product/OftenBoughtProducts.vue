<template>
    <section
        v-if="products !== null && products !== undefined && products.length > 0"
        class="often-bought-products"
    >
        <Container>
            <Reveal>
                <div class="often-bought-products__header">
                    <div>
                        <p class="often-bought-products__eyebrow">
                            Выбор наших садоводов
                        </p>
                        <h2 class="often-bought-products__title">
                            Растения, которые
                            <br class="often-bought-products__break" />
                            легко полюбить
                        </h2>
                    </div>
                    <div class="often-bought-products__copy">
                        <p class="often-bought-products__description">
                            Здоровая корневая система, выразительная листва и
                            адаптация к домашним условиям.
                        </p>
                        <Link
                            class="often-bought-products__link"
                            href="/catalog"
                        >
                            Смотреть весь каталог
                            <span class="often-bought-products__link-icon">
                                <Icon name="arrow" />
                            </span>
                        </Link>
                    </div>
                </div>
            </Reveal>
        </Container>
        <Reveal :delay="120" class="often-bought-products__slider">
            <ProductSlider :items="products" />
        </Reveal>
    </section>
</template>
<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import ProductSlider from '@/components/product/ProductSlider.vue';
import Reveal from '@/components/Reveal.vue';
import type { Product } from '@/types/product.ts';

interface Props {
    products: Product[],
}
const { products } = defineProps<Props>();
</script>

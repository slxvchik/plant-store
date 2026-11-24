<template>
    <Container>
        <div class="product-detail">
            <Breadcrumbs
                :items="[
                        { url: HomeIndex.url(), name: 'Главная' },
                        { url: CatalogIndex.url(), name: 'Каталог' },
                        { url: CatalogIndex.url() + '/' + product.alias, name: product.name },
                    ]"
            />

            <section class="product-detail__main">
                <div class="product-detail__gallery-column">
                    <ProductDetailSlider :slides="gallerySlides" />
                </div>

                <div class="product-detail__information">
                    <div class="product-detail__category-row">
                        <p class="product-detail__category">
                            {{ product?.category?.name }}
                        </p>
                    </div>
                    <h1 class="product-detail__title">{{ product?.name }}</h1>
                    <div class="product-detail__meta">
                        <span class="product-detail__availability">
                            <template v-if="selectedOfferAvailable">
                                <span
                                    class="product-detail__availability-dot product-detail__availability-dot--available"
                                />
                                В наличии
                            </template>
                            <template v-else>
                                <span
                                    class="product-detail__availability-dot product-detail__availability-dot--unavailable"
                                />
                                Отсутствует
                            </template>
                        </span>
                    </div>
                    <fieldset class="product-detail__sizes">
                        <legend class="product-detail__sizes-legend">
                            Размер растения
                        </legend>
                        <div class="product-detail__size-list">
                            <Button
                                v-for="offer in product.offers"
                                :key="offer.id"
                                :class="{
                                    'product-detail__size--selected':
                                        selectedOffer.id === offer.id,
                                }"
                                class="product-detail__size"
                                style-type="unstyled"
                                type="button"
                                @click="selectedOffer = offer"
                            >
                                <span class="product-detail__size-name">
                                    {{ offer.name }}
                                </span>
                            </Button>
                        </div>
                    </fieldset>

                    <div class="product-detail__purchase">
                        <div class="product-detail__price-row">
                            <span class="product-detail__price">
                                {{ currentPrice }} руб.
                            </span>
                        </div>
                    </div>
                </div>

                <p class="product-detail__description">
                    {{ selectedOffer.description ?? product?.description }}
                </p>
            </section>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import Button from '@/components/Button.vue';
import ProductDetailSlider from '@/components/catalog/ProductDetailSlider.vue';
import Container from '@/components/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { home as HomeIndex } from '@/routes';
import { index as CatalogIndex } from '@/routes/catalog';
import type { Offer, Product } from '@/types/product.ts';

defineOptions({ layout: AppLayout });
const { product } = defineProps<{ product: Product }>();

const selectedOffer = ref<Offer>(product.offers[0]);
const currentPrice = computed(() => 0);
const selectedOfferAvailable = computed(() => {
    return selectedOffer.value.stockQuantity !== null && selectedOffer.value.stockQuantity > 0;
});

const gallerySlides = computed(() => {
    return [...product.images, ...selectedOffer.value.images];
});
</script>

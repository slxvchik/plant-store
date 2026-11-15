<template>
    <article class="product-card">
        <Link
            :aria-label="`Подробнее о растении ${product.name}`"
            :href="`/catalog/${product.alias}`"
            class="product-card__media-link"
        >
            <div class="product-card__image-wrap">
                <img
                    :alt="product.image.altText ?? ''"
                    :src="product.image.webPathToFile"
                    class="product-card__image"
                    loading="lazy"
                />
            </div>
            <div v-if="product.tags.length > 0" class="product-card__tags">
                <span
                    v-for="tag in product.tags"
                    :key="`${product.id}-${tag.id}`"
                    class="product-card__tag"
                >
                    {{ tag.name }}
                </span>
            </div>
            <span class="product-card__arrow">
                <span class="product-card__arrow-icon">
                    <Icon name="arrow" />
                </span>
            </span>
        </Link>
        <div class="product-card__favorite">
            <FavoriteButton v-model="favorite" />
        </div>
        <div class="product-card__body">
            <p v-if="product.category" class="product-card__category">
                {{ product.category }}
            </p>
            <Link
                :href="`/catalog/${product.alias}`"
                class="product-card__name"
            >
                {{ product.name }}
            </Link>
            <div v-if="false" class="product-card__rating">
                <svg
                    aria-hidden="true"
                    class="product-card__star"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8-6.2-3.2L5.8 21 7 14.2l-5-4.9 6.9-1z"
                    />
                </svg>
                <span class="product-card__rating-value">1</span>
                <span class="product-card__rating-count">1</span>
            </div>
            <div class="product-card__bottom">
                <div class="product-card__prices">
                    <span class="product-card__price">
                        {{ product.minPrice }}
                    </span>
                    <span
                        v-if="product.oldPrice"
                        class="product-card__old-price"
                    >
                        {{ product.oldPrice }}
                    </span>
                </div>
                <Button
                    class="product-card__cart"
                    :aria-label="`Добавить ${product.name} в корзину`"
                    style-type="link"
                    type="button"
                    @click="console.log('add to card!')"
                >
                    <span class="product-card__cart-icon">
                        <Icon name="cart" />
                    </span>
                    <span class="product-card__cart-text">В корзину</span>
                </Button>
            </div>
        </div>
    </article>
</template>
<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import FavoriteButton from '@/components/product/FavoriteButton.vue';
import type { ProductListItem } from '@/types/product.ts';

defineProps<{ product: ProductListItem }>();
const favorite = ref(false);
</script>

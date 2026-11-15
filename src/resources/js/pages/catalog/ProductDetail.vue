<template>
    <div class="product-detail">
        <div class="product-detail__breadcrumbs-wrap">
            <nav
                aria-label="Хлебные крошки"
                class="product-detail__breadcrumbs"
            >
                <Link class="product-detail__breadcrumb-link" href="/">
                    Главная
                </Link>
                <span>/</span>
                <Link class="product-detail__breadcrumb-link" href="/catalog">
                    Каталог
                </Link>
                <span>/</span>
                <span class="product-detail__breadcrumb-current">
                    {{ product?.name }}
                </span>
            </nav>
        </div>

        <section class="product-detail__main">
            <div class="product-detail__gallery-column">
                <div
                    aria-label="Галерея растения"
                    class="product-detail__gallery"
                >
                    TODO: Product slider
                </div>
            </div>

            <div class="product-detail__information">
                <div class="product-detail__category-row">
                    <p class="product-detail__category">
                        {{ product?.category }}
                    </p>
                    <FavoriteButton v-model="favorite" />
                </div>
                <h1 class="product-detail__title">{{ product?.name }}</h1>
                <div class="product-detail__meta">
                    <div v-if="false" class="product-detail__rating">
                        <span class="product-detail__rating-star">★</span>
                        <span class="product-detail__rating-value">1</span>
                        <a class="product-detail__reviews" href="#reviews">
                            5 отзывов
                        </a>
                    </div>
                    <span class="product-detail__availability">
                        <span class="product-detail__availability-dot" />
                        В наличии
                    </span>
                </div>
                <p class="product-detail__description">
                    {{ product?.description }}
                </p>

                <div class="product-detail__features">
                    <div class="product-detail__feature">
                        <p class="product-detail__feature-label">Освещение</p>
                        <p class="product-detail__feature-value">Освещение</p>
                    </div>
                    <div class="product-detail__feature">
                        <p class="product-detail__feature-label">
                            Сложность ухода
                        </p>
                        <p class="product-detail__feature-value">Средняя</p>
                    </div>
                </div>

                <fieldset class="product-detail__sizes">
                    <legend class="product-detail__sizes-legend">
                        Размер растения
                    </legend>
                    <div class="product-detail__size-list">
                        <Button
                            v-for="option in sizeOptions"
                            :key="option.name"
                            :class="{
                                'product-detail__size--selected':
                                    selectedSize === option.name,
                            }"
                            class="product-detail__size"
                            style-type="unstyled"
                            type="button"
                            @click="selectedSize = option.name"
                        >
                            <span class="product-detail__size-name">
                                {{ option.name }}
                            </span>
                            <span class="product-detail__size-height">
                                {{ option.height }}
                            </span>
                        </Button>
                    </div>
                </fieldset>

                <div class="product-detail__purchase">
                    <div class="product-detail__price-row">
                        <span class="product-detail__price">
                            {{ currentPrice }}
                        </span>
                        <span class="product-detail__old-price">
                            Старая цена
                        </span>
                    </div>
                    <div class="product-detail__purchase-actions">
                        <div class="product-detail__quantity">
                            <Button
                                aria-label="Уменьшить количество"
                                class="product-detail__quantity-button"
                                style-type="unstyled"
                                type="button"
                                @click="quantity = Math.max(1, quantity - 1)"
                            >
                                <Icon name="minus" />
                            </Button>
                            <span class="product-detail__quantity-value">
                                {{ quantity }}
                            </span>
                            <Button
                                aria-label="Увеличить количество"
                                class="product-detail__quantity-button"
                                style-type="unstyled"
                                type="button"
                                @click="quantity += 1"
                            >
                                <Icon name="plus" />
                            </Button>
                        </div>
                        <Button
                            class="product-detail__cart-button"
                            style-type="link"
                            type="button"
                            @click="addSelectedToCart"
                        >
                            <span class="product-detail__cart-icon">
                                <Icon name="cart" />
                            </span>
                            В корзину
                        </Button>
                    </div>
                </div>

                <div v-if="false" class="product-detail__benefits">
                    <p class="product-detail__benefit">
                        <span class="product-detail__benefit-icon">
                            <Icon name="truck" />
                        </span>
                        Доставим по Москве завтра, по России — от 2 дней
                    </p>
                    <p class="product-detail__benefit">
                        <span class="product-detail__benefit-icon">
                            <Icon name="shield" />
                        </span>
                        30 дней гарантии и поддержка садовода
                    </p>
                </div>

                <div class="product-detail__care">
                    <AccordionItem
                        v-for="(care, index) in careItems"
                        :key="care.question"
                        :is-open="openCare === index"
                        :question="care.question"
                        @toggle="openCare = openCare === index ? null : index"
                    >
                        {{ care.answer }}
                    </AccordionItem>
                </div>
            </div>
        </section>

        <section class="product-detail__related">
            <div class="product-detail__related-container">
                <Reveal>
                    <div class="product-detail__related-header">
                        <div>
                            <p class="product-detail__related-eyebrow">
                                Создайте свою коллекцию
                            </p>
                            <h2 class="product-detail__related-title">
                                Вам также подойдут
                            </h2>
                        </div>
                        <Link
                            class="product-detail__related-link"
                            href="/catalog"
                        >
                            Весь каталог
                            <span class="product-detail__related-link-icon">
                                <Icon name="arrow" />
                            </span>
                        </Link>
                    </div>
                </Reveal>
                <Reveal :delay="100" class="product-detail__related-slider">
                    <ProductSlider :items="[]" />
                </Reveal>
            </div>
        </section>

        <div class="product-detail__mobile-purchase">
            <div class="product-detail__mobile-purchase-inner">
                <div class="product-detail__mobile-summary">
                    <p class="product-detail__mobile-meta">
                        {{ selectedSize }} · {{ quantity }} шт.
                    </p>
                    <p class="product-detail__mobile-price">
                        {{ currentPrice * quantity }}
                    </p>
                </div>
                <div
                    class="product-detail__quantity product-detail__quantity--mobile"
                >
                    <Button
                        aria-label="Уменьшить количество"
                        class="product-detail__quantity-button product-detail__quantity-button--mobile"
                        style-type="unstyled"
                        type="button"
                        @click="quantity = Math.max(1, quantity - 1)"
                    >
                        <Icon name="minus" />
                    </Button>
                    <span
                        class="product-detail__quantity-value product-detail__quantity-value--mobile"
                    >
                        {{ quantity }}
                    </span>
                    <Button
                        aria-label="Увеличить количество"
                        class="product-detail__quantity-button product-detail__quantity-button--mobile"
                        style-type="unstyled"
                        type="button"
                        @click="quantity += 1"
                    >
                        <Icon name="plus" />
                    </Button>
                </div>
                <Button
                    class="product-detail__cart-button product-detail__cart-button--mobile"
                    style-type="unstyled"
                    type="button"
                    @click="addSelectedToCart"
                >
                    <span class="product-detail__cart-icon">
                        <Icon name="cart" />
                    </span>
                    <span class="product-detail__mobile-cart-text">
                        В корзину
                    </span>
                </Button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AccordionItem from '@/components/AccordionItem.vue';
import Button from '@/components/Button.vue';
import Icon from '@/components/icons/Icon.vue';
import FavoriteButton from '@/components/product/FavoriteButton.vue';
import ProductSlider from '@/components/product/ProductSlider.vue';
import Reveal from '@/components/Reveal.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Product } from '@/types/product.ts';

defineOptions({ layout: AppLayout });
defineProps<{ product: Product }>();

const favorite = ref(false);
const quantity = ref(1);
const selectedSize = ref('Среднее');
const openCare = ref<number | null>(0);
const sizeOptions = [
    { name: 'Компактное', height: '30–45 см', extra: 0 },
    { name: 'Среднее', height: '50–70 см', extra: 900 },
    { name: 'Крупное', height: '80–110 см', extra: 1800 },
];
const currentPrice = computed(() => 0);
const careItems = [
    {
        question: 'Освещение и размещение',
        answer: 'Лучше всего растение чувствует себя в ярком рассеянном свете. Избегайте прямых полуденных лучей и резких перепадов температуры. Поворачивайте горшок раз в две недели для равномерного роста.',
    },
    {
        question: 'Полив и влажность',
        answer: 'Поливайте после просыхания верхних 2–3 см грунта. Зимой сократите полив. Опрыскивайте листья или используйте увлажнитель, если воздух в комнате сухой.',
    },
    {
        question: 'Пересадка и подкормка',
        answer: 'Молодые растения пересаживают весной раз в год, взрослые — по мере роста корней. С марта по сентябрь используйте сбалансированное удобрение два раза в месяц.',
    },
    {
        question: 'Доставка и гарантия',
        answer: 'Мы надёжно фиксируем растение и грунт в упаковке. После получения дайте растению 7–10 дней на адаптацию. Наши садоводы остаются на связи в течение всего гарантийного периода.',
    },
];

const addSelectedToCart = (): void => {
    console.log('В корзину');
};
</script>

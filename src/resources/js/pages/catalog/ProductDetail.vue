<template>
    <div class="bg-bg-base pb-8 dark:bg-bg-night">
        <div class="mx-auto max-w-[1440px] px-4 pt-5 md:px-8 md:pt-8">
            <nav
                class="flex items-center gap-2 overflow-hidden text-xs whitespace-nowrap text-text-muted dark:text-white/40"
                aria-label="Хлебные крошки"
            >
                <Link href="/" class="transition-colors hover:text-primary">
                    Главная
                </Link>
                <span>/</span>
                <Link
                    href="/catalog"
                    class="transition-colors hover:text-primary"
                >
                    Каталог
                </Link>
                <span>/</span>
                <span class="truncate text-text-title dark:text-white/65">
                    {{ product?.name }}
                </span>
            </nav>
        </div>
        <section
            class="mx-auto grid max-w-[1440px] gap-8 px-4 py-6 md:px-8 md:py-10 lg:grid-cols-[1.08fr_0.92fr] lg:gap-12 xl:gap-20"
        >
            <div>
                <div
                    class="hide-scrollbar -mx-4 flex snap-x snap-mandatory overflow-x-scroll md:-mx-8 lg:hidden"
                    aria-label="Галерея растения"
                >
                    TODO: Product slider
                </div>
            </div>

            <div class="lg:py-3">
                <div class="flex items-center justify-between gap-4">
                    <p
                        class="text-xs font-semibold tracking-[0.18em] text-primary uppercase dark:text-secondary"
                    >
                        {{ product?.category }}
                    </p>
                    <FavoriteButton v-model="favorite" />
                </div>
                <h1
                    class="mt-3 font-serif text-4xl leading-[1.08] text-text-title md:text-5xl xl:text-6xl dark:text-linen"
                >
                    {{ product?.name }}
                </h1>
                <div class="mt-4 flex items-center gap-2 text-sm">
                    <div v-if="false" class="flex gap-2">
                        <span class="text-accent">★</span>
                        <span
                            class="font-semibold text-text-title dark:text-white"
                        >
                            1
                        </span>
                        <a
                            href="#reviews"
                            class="text-text-muted underline decoration-text-muted/30 underline-offset-4 dark:text-white/45"
                        >
                            5 отзывов
                        </a>
                    </div>
                    <span
                        class="ml-auto flex items-center gap-1.5 text-xs font-medium text-primary dark:text-secondary"
                    >
                        <span
                            class="h-2 w-2 rounded-full bg-primary dark:bg-secondary"
                        />
                        В наличии
                    </span>
                </div>
                <p
                    class="mt-6 text-[15px] leading-7 text-text-muted md:text-base dark:text-white/55"
                >
                    {{ product?.description }}
                </p>

                <div class="mt-7 grid grid-cols-2 gap-3">
                    <div
                        class="rounded-2xl bg-bg-surface p-4 dark:bg-bg-night-soft"
                    >
                        <p class="text-xs text-text-muted dark:text-white/40">
                            Освещение
                        </p>
                        <p
                            class="mt-1 text-sm font-semibold text-text-title dark:text-white"
                        >
                            Освещение
                        </p>
                    </div>
                    <div
                        class="rounded-2xl bg-bg-surface p-4 dark:bg-bg-night-soft"
                    >
                        <p class="text-xs text-text-muted dark:text-white/40">
                            Сложность ухода
                        </p>
                        <p
                            class="mt-1 text-sm font-semibold text-text-title dark:text-white"
                        >
                            Средняя
                        </p>
                    </div>
                </div>

                <fieldset class="mt-7">
                    <legend
                        class="text-sm font-semibold text-text-title dark:text-linen"
                    >
                        Размер растения
                    </legend>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <button
                            v-for="option in sizeOptions"
                            :key="option.name"
                            type="button"
                            class="min-h-14 cursor-pointer rounded-xl border px-2 text-xs transition-all duration-300 dark:text-white"
                            :class="
                                selectedSize === option.name
                                    ? 'border-primary bg-sage-soft/60 text-primary dark:border-secondary dark:bg-primary/20 dark:text-secondary'
                                    : 'border-text-title/10 text-text-muted hover:border-primary/40 dark:border-white/15 dark:text-white/50'
                            "
                            @click="selectedSize = option.name"
                        >
                            <span class="block font-semibold">
                                {{ option.name }}
                            </span>
                            <span class="mt-0.5 block opacity-60">
                                {{ option.height }}
                            </span>
                        </button>
                    </div>
                </fieldset>

                <div
                    class="mt-8 hidden items-center justify-between gap-5 lg:flex"
                >
                    <div>
                        <div class="flex items-baseline gap-3">
                            <span
                                class="font-serif text-4xl font-semibold text-text-title dark:text-linen"
                            >
                                {{ currentPrice }}
                            </span>
                            <span
                                class="text-sm text-text-muted line-through dark:text-white/35"
                            >
                                Старая цена
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-12 items-center rounded-full border border-text-title/15 dark:border-white/15"
                        >
                            <button
                                type="button"
                                class="flex h-11 w-11 cursor-pointer items-center justify-center text-text-title dark:text-white"
                                aria-label="Уменьшить количество"
                                @click="quantity = Math.max(1, quantity - 1)"
                            >
                                <span class="h-4 w-4">
                                    <AppIcon name="minus" />
                                </span>
                            </button>
                            <span class="w-5 text-center text-sm font-semibold">
                                {{ quantity }}
                            </span>
                            <button
                                type="button"
                                class="flex h-11 w-11 cursor-pointer items-center justify-center text-text-title dark:text-white"
                                aria-label="Увеличить количество"
                                @click="quantity += 1"
                            >
                                <span class="h-4 w-4">
                                    <AppIcon name="plus" />
                                </span>
                            </button>
                        </div>
                        <button
                            type="button"
                            class="flex min-h-12 cursor-pointer items-center gap-2 rounded-full bg-primary px-6 text-sm font-semibold text-white shadow-lg shadow-primary/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-primary-hover"
                            @click="addSelectedToCart"
                        >
                            <span class="h-5 w-5"><AppIcon name="cart" /></span>
                            В корзину
                        </button>
                    </div>
                </div>

                <div
                    class="mt-8 space-y-3 border-t border-text-title/10 pt-6 dark:border-white/10"
                    v-if="false"
                >
                    <p
                        class="flex items-center gap-3 text-sm text-text-muted dark:text-white/55"
                    >
                        <span class="h-5 w-5 text-primary dark:text-secondary">
                            <AppIcon name="truck" />
                        </span>
                        Доставим по Москве завтра, по России — от 2 дней
                    </p>
                    <p
                        class="flex items-center gap-3 text-sm text-text-muted dark:text-white/55"
                    >
                        <span class="h-5 w-5 text-primary dark:text-secondary">
                            <AppIcon name="shield" />
                        </span>
                        30 дней гарантии и поддержка садовода
                    </p>
                </div>

                <div
                    class="mt-8 border-t border-text-title/10 dark:border-white/10"
                >
                    <AccordionItem
                        v-for="(care, index) in careItems"
                        :key="care.question"
                        :question="care.question"
                        :is-open="openCare === index"
                        @toggle="openCare = openCare === index ? null : index"
                    >
                        {{ care.answer }}
                    </AccordionItem>
                </div>
            </div>
        </section>

        <section class="overflow-hidden px-4 py-14 md:px-8 md:py-20">
            <div class="mx-auto max-w-[1440px]">
                <Reveal>
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p
                                class="text-xs font-semibold tracking-[0.18em] text-accent uppercase"
                            >
                                Создайте свою коллекцию
                            </p>
                            <h2
                                class="mt-3 font-serif text-3xl text-text-title md:text-4xl dark:text-linen"
                            >
                                Вам также подойдут
                            </h2>
                        </div>
                        <Link
                            href="/catalog"
                            class="hidden min-h-11 items-center gap-2 text-sm font-semibold text-primary md:flex dark:text-secondary"
                        >
                            Весь каталог
                            <span class="h-4 w-4">
                                <AppIcon name="arrow" />
                            </span>
                        </Link>
                    </div>
                </Reveal>
                <Reveal :delay="100" class="mt-8">
                    <ProductSlider :items="[]" />
                </Reveal>
            </div>
        </section>

        <div
            class="fixed inset-x-0 bottom-[74px] z-30 border-t border-text-title/10 bg-bg-elevated/95 px-4 py-3 shadow-[0_-10px_30px_rgba(32,43,38,0.1)] backdrop-blur-xl lg:hidden dark:border-white/10 dark:bg-bg-night-soft/95"
        >
            <div class="mx-auto flex max-w-lg items-center gap-3">
                <div class="min-w-0 flex-1">
                    <p
                        class="truncate text-[10px] text-text-muted dark:text-white/40"
                    >
                        {{ selectedSize }} · {{ quantity }} шт.
                    </p>
                    <p
                        class="font-serif text-xl font-semibold text-text-title dark:text-linen"
                    >
                        {{ currentPrice * quantity }}
                    </p>
                </div>
                <div
                    class="flex h-11 items-center rounded-full border border-text-title/10 dark:border-white/15"
                >
                    <button
                        type="button"
                        class="flex h-11 w-9 cursor-pointer items-center justify-center dark:text-white"
                        aria-label="Уменьшить количество"
                        @click="quantity = Math.max(1, quantity - 1)"
                    >
                        <span class="h-4 w-4"><AppIcon name="minus" /></span>
                    </button>
                    <span
                        class="w-4 text-center text-sm font-semibold dark:text-white"
                    >
                        {{ quantity }}
                    </span>
                    <button
                        type="button"
                        class="flex h-11 w-9 cursor-pointer items-center justify-center dark:text-white"
                        aria-label="Увеличить количество"
                        @click="quantity += 1"
                    >
                        <span class="h-4 w-4"><AppIcon name="plus" /></span>
                    </button>
                </div>
                <button
                    type="button"
                    class="flex min-h-11 cursor-pointer items-center gap-2 rounded-full bg-primary px-5 text-sm font-semibold text-white transition-all duration-300 active:scale-95"
                    @click="addSelectedToCart"
                >
                    <span class="h-4 w-4"><AppIcon name="cart" /></span>
                    <span class="hidden min-[390px]:inline">В корзину</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AccordionItem from '@/components/AccordionItem.vue';
import AppIcon from '@/components/AppIcon.vue';
import FavoriteButton from '@/components/FavoriteButton.vue';
import Layout from '@/components/layouts/Layout.vue';
import ProductSlider from '@/components/product/ProductSlider.vue';
import Reveal from '@/components/Reveal.vue';
import type { Product } from '@/types/product.ts';

defineOptions({ layout: Layout });
defineProps<{ product: Product }>();

const activeImage = ref(0);
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

const onGalleryScroll = (event: Event): void => {
    const galleryElement = event.currentTarget as HTMLElement;
    activeImage.value = Math.round(
        galleryElement.scrollLeft / galleryElement.clientWidth,
    );
};

const addSelectedToCart = (): void => {
    console.log('В корзину');
};
</script>

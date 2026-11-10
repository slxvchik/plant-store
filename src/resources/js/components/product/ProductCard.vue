<template>
    <article
        class="group relative flex h-full w-full flex-col overflow-hidden rounded-[20px] border border-text-title/5 bg-bg-elevated shadow-[0_2px_12px_rgba(32,43,38,0.03)] transition-all duration-300 ease-in-out hover:-translate-y-1 md:rounded-[24px] dark:border-white/10 dark:bg-bg-night-soft"
    >
        <Link
            :aria-label="`Подробнее о растении ${item.name}`"
            :href="`/catalog/${item.id}`"
            class="relative block overflow-hidden"
        >
            <div
                class="aspect-[4/5] overflow-hidden bg-bg-surface dark:bg-white/5"
            >
                <img
                    :alt="item.name"
                    :src="item.image"
                    class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.07]"
                    loading="lazy"
                />
            </div>
            <span
                v-if="item.tag"
                class="absolute top-2.5 left-2.5 rounded-full bg-bg-elevated/90 px-2.5 py-1 text-[10px] font-semibold tracking-wide text-primary backdrop-blur md:top-4 md:left-4 md:px-3 md:text-xs dark:bg-bg-night/80 dark:text-secondary"
            >
                {{ item.tag }}
            </span>
            <span
                class="absolute right-3 bottom-3 hidden h-10 w-10 translate-y-2 items-center justify-center rounded-full bg-white text-primary opacity-0 shadow-lg transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100 md:flex"
            >
                <span class="h-4 w-4"><AppIcon name="arrow" /></span>
            </span>
        </Link>
        <div class="absolute top-2.5 right-2.5 z-10">
            <FavoriteButton v-model="favorite" />
        </div>
        <div class="flex flex-1 flex-col p-3 md:p-5">
            <p
                class="truncate text-[10px] font-medium tracking-[0.12em] text-text-muted uppercase md:text-xs dark:text-white/40"
            >
                {{ item.category }}
            </p>
            <Link
                :href="`/catalog/${item.id}`"
                class="mt-1.5 font-serif text-[17px] leading-tight font-medium text-text-title transition-colors duration-300 hover:text-primary md:mt-2 md:text-[22px] dark:text-linen dark:hover:text-secondary"
            >
                {{ item.name }}
            </Link>
            <p
                class="mt-1 hidden text-xs text-text-muted italic md:block dark:text-white/40"
            >
                {{ item.latinName }}
            </p>
            <div
                class="mt-2 flex items-center gap-1.5 text-xs text-text-muted md:mt-3 dark:text-white/45"
            >
                <svg
                    aria-hidden="true"
                    class="h-3.5 w-3.5 text-accent"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8-6.2-3.2L5.8 21 7 14.2l-5-4.9 6.9-1z"
                    />
                </svg>
                <span class="font-semibold text-text-title dark:text-white/70">
                    {{ item.rating }}
                </span>
                <span class="hidden sm:inline">({{ item.reviews }})</span>
            </div>
            <div
                class="mt-auto flex flex-col gap-3 pt-4 md:flex-row md:items-end md:justify-between"
            >
                <div class="flex flex-wrap items-baseline gap-2">
                    <span
                        class="text-lg font-semibold text-text-title md:text-xl dark:text-linen"
                    >
                        {{ formatPrice(item.price) }}
                    </span>
                    <span
                        v-if="item.oldPrice"
                        class="text-xs text-text-muted line-through dark:text-white/35"
                    >
                        {{ formatPrice(item.oldPrice) }}
                    </span>
                </div>
                <button
                    :aria-label="`Добавить ${item.name} в корзину`"
                    class="flex min-h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-full bg-primary px-4 text-xs font-semibold text-white transition-all duration-300 ease-in-out hover:bg-primary-hover hover:shadow-lg active:scale-95 md:w-11 md:px-0 lg:w-auto lg:px-4"
                    type="button"
                    @click="
                        addToCart({
                            id: item.id,
                            name: item.name,
                            price: item.price,
                            image: item.image,
                        })
                    "
                >
                    <span class="h-4 w-4 md:hidden lg:block">
                        <AppIcon name="cart" />
                    </span>
                    <span class="md:hidden lg:inline">В корзину</span>
                    <span class="hidden md:inline lg:hidden">
                        <AppIcon name="plus" />
                    </span>
                </button>
            </div>
        </div>
    </article>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import FavoriteButton from '@/components/FavoriteButton.vue';
import { useCartDrawer } from '@/composables/useCartDrawer.ts';
import { storefrontProducts } from '@/data/products.ts';

const props = defineProps<{ product?: (typeof storefrontProducts)[number] }>();
const item = computed(() => props.product ?? storefrontProducts[0]!);
const favorite = ref(false);
const { addToCart, formatPrice } = useCartDrawer();
</script>

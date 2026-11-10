<template>
    <Container class="bg-bg-base dark:bg-bg-night">
        <section
            class="border-b border-text-title/5 py-9 md:py-14 dark:border-white/10"
        >
            <div>
                <Breadcrumbs
                    :items="[
                        { url: home.url(), name: 'Главная' },
                        { url: home.url(), name: 'Каталог' },
                    ]"
                />
                <div
                    class="mt-5 flex flex-col gap-5 md:flex-row md:items-end md:justify-between"
                >
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.2em] text-accent uppercase"
                        >
                            Коллекция питомника
                        </p>
                        <h1
                            class="mt-3 font-serif text-4xl leading-tight text-text-title md:text-5xl lg:text-6xl dark:text-linen"
                        >
                            Найдите своё
                            <em class="text-primary dark:text-secondary">
                                растение
                            </em>
                        </h1>
                    </div>
                    <p
                        class="max-w-md text-sm leading-6 text-text-muted md:text-base dark:text-white/50"
                    >
                        Живые растения для дома, террасы и сада. Каждый
                        экземпляр проверен нашими садоводами.
                    </p>
                </div>
            </div>
        </section>

        <div class="py-6 md:py-10">
            <div
                class="mb-6 flex flex-col gap-3 md:mb-8 md:flex-row md:items-center"
            >
                <label class="relative flex-1">
                    <span class="sr-only">Поиск по каталогу</span>
                    <span
                        class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-text-muted dark:text-white/40"
                    >
                        <AppIcon name="search" />
                    </span>
                    <input
                        v-model="searchQuery"
                        type="search"
                        placeholder="Название или сорт растения"
                        class="h-12 w-full rounded-full border border-text-title/10 bg-bg-elevated pr-4 pl-12 text-sm text-text-title transition-all duration-300 placeholder:text-text-muted/60 focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none dark:border-white/10 dark:bg-bg-night-soft dark:text-white dark:placeholder:text-white/30"
                    />
                </label>
                <label class="relative md:w-72">
                    <span class="sr-only">Сортировка товаров</span>
                    <select
                        v-model="productsSort"
                        class="h-12 w-full cursor-pointer appearance-none rounded-full border border-text-title/10 bg-bg-elevated px-5 pr-11 text-sm font-medium text-text-title transition-all duration-300 focus:border-primary focus:outline-none dark:border-white/10 dark:bg-bg-night-soft dark:text-white"
                    >
                        <option
                            v-for="item in sortItems"
                            :key="item.value"
                            :value="item.value"
                        >
                            {{ item.label }}
                        </option>
                    </select>
                    <span
                        class="pointer-events-none absolute top-1/2 right-4 h-4 w-4 -translate-y-1/2 rotate-90 text-text-muted dark:text-white/40"
                    >
                        <AppIcon name="chevron" />
                    </span>
                </label>
            </div>

            <div
                class="lg:grid lg:grid-cols-[240px_minmax(0,1fr)] lg:gap-8 xl:grid-cols-[264px_minmax(0,1fr)] xl:gap-10"
            >
                <aside class="hidden lg:block">
                    <div
                        class="sticky top-28 max-h-[calc(100dvh-8rem)] overflow-y-auto pr-2"
                    >
                        <div class="mb-6 flex items-center justify-between">
                            <h2
                                class="font-serif text-2xl text-text-title dark:text-linen"
                            >
                                Фильтры
                            </h2>
                            <span
                                v-if="activeFiltersCount"
                                class="rounded-full bg-sage-soft px-2.5 py-1 text-xs font-semibold text-primary dark:bg-primary/25 dark:text-secondary"
                            >
                                {{ activeFiltersCount }}
                            </span>
                        </div>
                        <CatalogFilters
                            id-prefix="desktop"
                            v-model:categories="selectedCategories"
                            v-model:lights="selectedLight"
                            v-model:max-price="maxPrice"
                            v-model:in-stock="onlyInStock"
                            @reset="resetFilters"
                        />
                    </div>
                </aside>
                <div>
                    <div class="mb-5 flex items-center justify-between text-sm">
                        <p class="text-text-muted dark:text-white/45">
                            <span
                                class="font-semibold text-text-title dark:text-white"
                            >
                                {{ filteredProducts.length }}
                            </span>
                            {{ resultLabel }}
                        </p>
                        <p
                            class="hidden text-text-muted md:block dark:text-white/40"
                        >
                            Есть вопросы?
                            <Link
                                href="/contacts"
                                class="text-primary underline decoration-primary/30 underline-offset-4 dark:text-secondary"
                            >
                                Поможем выбрать
                            </Link>
                        </p>
                    </div>
                    <TransitionGroup
                        v-if="filteredProducts.length"
                        tag="div"
                        name="products"
                        class="relative grid grid-cols-2 gap-3 md:grid-cols-3 md:gap-5 lg:grid-cols-4"
                        @before-leave="beforeRemoveProduct"
                    >
                        <div
                            v-for="product in filteredProducts"
                            :key="product.id"
                        >
                            <ProductCard :product="product" />
                        </div>
                    </TransitionGroup>
                    <div
                        v-else
                        class="flex min-h-[420px] flex-col items-center justify-center rounded-[28px] border border-dashed border-text-title/15 px-6 text-center dark:border-white/15"
                    >
                        <span
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-sage-soft text-primary dark:bg-primary/20 dark:text-secondary"
                        >
                            <span class="h-7 w-7">
                                <AppIcon name="search" />
                            </span>
                        </span>
                        <h2
                            class="mt-5 font-serif text-2xl text-text-title dark:text-linen"
                        >
                            Ничего не нашли
                        </h2>
                        <p
                            class="mt-2 max-w-sm text-sm leading-6 text-text-muted dark:text-white/50"
                        >
                            Попробуйте изменить запрос или сбросить фильтры — в
                            коллекции найдётся растение для вас.
                        </p>
                        <button
                            type="button"
                            class="mt-5 min-h-11 cursor-pointer rounded-full bg-primary px-5 text-sm font-semibold text-white transition-all duration-300 hover:bg-primary-hover"
                            @click="
                                resetFilters();
                                searchQuery = '';
                            "
                        >
                            Сбросить фильтры
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="fixed inset-x-0 bottom-22 z-30 flex justify-center lg:hidden"
        >
            <button
                type="button"
                class="flex min-h-12 cursor-pointer items-center gap-2 rounded-full bg-bg-dark px-6 text-sm font-semibold text-white shadow-[0_12px_35px_rgba(30,41,36,0.3)] transition-all duration-300 hover:scale-105 active:scale-95 dark:bg-secondary dark:text-bg-dark"
                @click="filtersOpen = true"
            >
                <span class="h-5 w-5"><AppIcon name="filter" /></span>
                Фильтры
                <span
                    v-if="activeFiltersCount"
                    class="flex h-5 min-w-5 items-center justify-center rounded-full bg-accent px-1 text-[10px] text-white"
                >
                    {{ activeFiltersCount }}
                </span>
            </button>
        </div>

        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                leave-active-class="transition-opacity duration-300"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="filtersOpen"
                    class="fixed inset-0 z-[60] bg-bg-dark/45 backdrop-blur-sm lg:hidden"
                    @click="filtersOpen = false"
                />
            </Transition>
            <Transition
                enter-active-class="transform-gpu transition-transform duration-500 ease-out"
                enter-from-class="translate-y-full"
                enter-to-class="translate-y-0"
                leave-active-class="transform-gpu transition-transform duration-300 ease-in"
                leave-to-class="translate-y-full"
            >
                <section
                    v-if="filtersOpen"
                    class="fixed inset-x-0 bottom-0 z-[70] flex h-[92dvh] flex-col rounded-t-[28px] bg-bg-elevated shadow-2xl lg:hidden dark:bg-bg-night-soft"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Фильтры каталога"
                >
                    <div
                        class="mx-auto mt-2 h-1 w-10 rounded-full bg-text-title/15 dark:bg-white/20"
                    />
                    <div
                        class="flex items-center justify-between border-b border-text-title/10 px-5 py-4 dark:border-white/10"
                    >
                        <div>
                            <p
                                class="text-xs tracking-widest text-primary uppercase dark:text-secondary"
                            >
                                Настроить коллекцию
                            </p>
                            <h2
                                class="mt-1 font-serif text-3xl text-text-title dark:text-linen"
                            >
                                Фильтры
                            </h2>
                        </div>
                        <button
                            type="button"
                            class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-bg-surface text-text-title transition-all duration-300 hover:rotate-90 dark:bg-white/5 dark:text-white"
                            aria-label="Закрыть фильтры"
                            @click="filtersOpen = false"
                        >
                            <span class="h-5 w-5">
                                <AppIcon name="close" />
                            </span>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto px-5 py-6">
                        <CatalogFilters
                            id-prefix="mobile"
                            v-model:categories="selectedCategories"
                            v-model:lights="selectedLight"
                            v-model:max-price="maxPrice"
                            v-model:in-stock="onlyInStock"
                            @reset="resetFilters"
                        />
                    </div>
                    <div
                        class="border-t border-text-title/10 p-4 pb-[max(1rem,env(safe-area-inset-bottom))] dark:border-white/10"
                    >
                        <button
                            type="button"
                            class="min-h-13 w-full cursor-pointer rounded-full bg-primary font-semibold text-white transition-all duration-300 hover:bg-primary-hover active:scale-[0.98]"
                            @click="filtersOpen = false"
                        >
                            Показать: {{ filteredProducts.length }}
                        </button>
                    </div>
                </section>
            </Transition>
        </Teleport>
    </Container>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import AppIcon from '@/components/AppIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import CatalogFilters from '@/components/CatalogFilters.vue';
import Container from '@/components/Container.vue';
import Layout from '@/components/layouts/Layout.vue';
import ProductCard from '@/components/product/ProductCard.vue';
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';
import { storefrontProducts } from '@/data/products';
import { home } from '@/routes';

defineOptions({ layout: Layout });

const sortItems = [
    { label: 'Сначала популярные', value: 'popularity' },
    { label: 'По дате поступления', value: 'date' },
    { label: 'Цена: по возрастанию', value: 'price-big' },
    { label: 'Цена: по убыванию', value: 'price-small' },
];
const productsSort = ref('popularity');
const searchQuery = ref('');
const filtersOpen = ref(false);
const selectedCategories = ref<string[]>([]);
const selectedLight = ref<string[]>([]);
const maxPrice = ref(7000);
const onlyInStock = ref(true);

const activeFiltersCount = computed(
    () =>
        selectedCategories.value.length +
        selectedLight.value.length +
        (maxPrice.value < 7000 ? 1 : 0) +
        (onlyInStock.value ? 1 : 0),
);
const filteredProducts = computed(() => {
    const query = searchQuery.value.trim().toLocaleLowerCase('ru');
    const result = storefrontProducts.filter((product) => {
        const matchesQuery =
            !query ||
            `${product.name} ${product.latinName}`
                .toLocaleLowerCase('ru')
                .includes(query);
        const matchesCategory =
            !selectedCategories.value.length ||
            selectedCategories.value.includes(product.category);
        const matchesLight =
            !selectedLight.value.length ||
            selectedLight.value.includes(product.light);
        const matchesStock = !onlyInStock.value || product.inStock !== false;

        return (
            matchesQuery &&
            matchesCategory &&
            matchesLight &&
            matchesStock &&
            product.price <= maxPrice.value
        );
    });

    return [...result].sort((a, b) => {
        if (productsSort.value === 'price-big') {
            return a.price - b.price;
        }

        if (productsSort.value === 'price-small') {
            return b.price - a.price;
        }

        if (productsSort.value === 'date') {
            return (
                Number(Boolean(b.tag === 'Новинка')) -
                Number(Boolean(a.tag === 'Новинка'))
            );
        }

        return b.rating * b.reviews - a.rating * a.reviews;
    });
});
const resultLabel = computed(() => {
    const count = filteredProducts.value.length;
    const lastTwo = count % 100;

    if (lastTwo >= 11 && lastTwo <= 14) {
        return 'растений';
    }

    if (count % 10 === 1) {
        return 'растение';
    }

    if (count % 10 >= 2 && count % 10 <= 4) {
        return 'растения';
    }

    return 'растений';
});

const resetFilters = (): void => {
    selectedCategories.value = [];
    selectedLight.value = [];
    maxPrice.value = 7000;
    onlyInStock.value = true;
};

const beforeRemoveProduct = (el: Element) => {
    const htmlEl = el as HTMLElement;
    const rect = htmlEl.getBoundingClientRect();

    htmlEl.style.width = `${rect.width}px`;
    htmlEl.style.height = `${rect.height}px`;
    htmlEl.style.left = `${htmlEl.offsetLeft}px`;
    htmlEl.style.top = `${htmlEl.offsetTop}px`;
};

useBodyScrollLock(filtersOpen);
</script>

<style>
.products-enter-active,
.products-leave-active,
.products-move {
    transition: all 10s cubic-bezier(0.25, 1, 0.5, 1);
}

.products-enter-from {
    opacity: 0;
    transform: translateY(6px);
}
.products-leave-to {
    opacity: 0;
    transform: translateY(6px);
}
.products-leave-active {
    pointer-events: none;
    position: absolute;
}
</style>

<template>
    <div class="catalog-index">
        <Container class="catalog-index__container">
            <Breadcrumbs
                :items="[
                    { url: HomeIndex.url(), name: 'Главная' },
                    { url: CatalogIndex.url(), name: 'Каталог' },
                ]"
            />
            <CatalogHero />
            <div class="catalog-index__content">
                <div class="catalog-index__toolbar">
                    <SearchInput
                        id="catalog-search-input"
                        v-model="searchQuery"
                    />
                    <div class="catalog-index__sort">
                        <Select
                            v-model="productsSort"
                            :items="sortItems"
                            variant="dropdown"
                        />
                    </div>
                </div>

                <div class="catalog-index__layout">
                    <aside class="catalog-index__sidebar">
                        <div class="catalog-index__sidebar-inner">
                            <div class="catalog-index__filter-heading">
                                <h2 class="catalog-index__filter-title">
                                    Фильтры
                                </h2>
                                <span
                                    v-if="activeFiltersCount"
                                    class="catalog-index__filter-count"
                                >
                                    {{ activeFiltersCount }}
                                </span>
                            </div>
                            <CatalogFilters
                                v-model:in-stock="onlyInStock"
                                v-model:max-price="maxPrice"
                                v-model:min-price="minPrice"
                                v-model:selected-categories="selectedCategories"
                                :all-categories="allCategories"
                                :max-price-base="props.maxPrice"
                                :min-price-base="props.minPrice"
                                id-prefix="desktop"
                                @reset="resetFilters"
                            />
                        </div>
                    </aside>
                    <div class="catalog-index__results">
                        <div class="catalog-index__results-meta">
                            <p class="catalog-index__results-count">
                                <span>{{ filteredProducts.length }}</span>
                                {{ resultLabel }}
                            </p>
                            <p class="catalog-index__help">
                                Есть вопросы?
                                <Link
                                    class="catalog-index__help-link"
                                    href="/contacts"
                                >
                                    Поможем выбрать
                                </Link>
                            </p>
                        </div>
                        <Transition name="catalog-index-fade" mode="out-in">
                            <TransitionGroup
                                v-if="filteredProducts.length"
                                class="catalog-index__products"
                                name="catalog-index-products"
                                tag="div"
                                @before-leave="beforeRemoveProduct"
                            >
                                <div
                                    v-for="product in filteredProducts"
                                    :key="product.id"
                                    class="catalog-index__product"
                                >
                                    <ProductCard :product="product" />
                                </div>
                            </TransitionGroup>
                            <div
                                v-else
                                class="catalog-index__empty"
                            >
                                <span class="catalog-index__empty-icon">
                                    <Icon name="search" />
                                </span>
                                <h2 class="catalog-index__empty-title">
                                    Ничего не нашли
                                </h2>
                                <p class="catalog-index__empty-text">
                                    Попробуйте изменить запрос или сбросить фильтры
                                    — в коллекции найдётся растение для вас.
                                </p>
                                <Button
                                    class="catalog-index__empty-reset"
                                    style-type="unstyled"
                                    type="button"
                                    @click="
                                        resetFilters();
                                        searchQuery = '';
                                    "
                                >
                                    Сбросить фильтры
                                </Button>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>

            <div class="catalog-index__mobile-trigger-wrap">
                <Button
                    class="catalog-index__mobile-trigger"
                    style-type="link"
                    type="button"
                    @click="filtersOpen = true"
                >
                    <span class="catalog-index__mobile-trigger-icon">
                        <Icon name="filter" />
                    </span>
                    Фильтры
                    <span
                        v-if="activeFiltersCount"
                        class="catalog-index__mobile-count"
                    >
                        {{ activeFiltersCount }}
                    </span>
                </Button>
            </div>

            <Teleport to="body">
                <Transition name="catalog-index-overlay">
                    <div
                        v-if="filtersOpen"
                        class="catalog-index__overlay"
                        @click="filtersOpen = false"
                    />
                </Transition>
                <Transition name="catalog-index-drawer">
                    <section
                        v-if="filtersOpen"
                        aria-label="Фильтры каталога"
                        aria-modal="true"
                        class="catalog-index__drawer"
                        role="dialog"
                    >
                        <div class="catalog-index__drawer-handle" />
                        <div class="catalog-index__drawer-header">
                            <div>
                                <p class="catalog-index__drawer-eyebrow">
                                    Настроить коллекцию
                                </p>
                                <h2 class="catalog-index__drawer-title">
                                    Фильтры
                                </h2>
                            </div>
                            <Button
                                aria-label="Закрыть фильтры"
                                class="catalog-index__drawer-close"
                                style-type="unstyled"
                                type="button"
                                @click="filtersOpen = false"
                            >
                                <Icon name="close" />
                            </Button>
                        </div>
                        <div class="catalog-index__drawer-body">
                            <CatalogFilters
                                v-model:in-stock="onlyInStock"
                                v-model:max-price="maxPrice"
                                v-model:min-price="minPrice"
                                v-model:selected-categories="selectedCategories"
                                :all-categories="allCategories"
                                :max-price-base="props.maxPrice"
                                :min-price-base="props.minPrice"
                                id-prefix="mobile"
                                @reset="resetFilters"
                            />
                        </div>
                        <div class="catalog-index__drawer-footer">
                            <Button
                                class="catalog-index__drawer-submit"
                                style-type="link"
                                type="button"
                                @click="filtersOpen = false"
                            >
                                Показать: {{ filteredProducts.length }}
                            </Button>
                        </div>
                    </section>
                </Transition>
            </Teleport>
        </Container>
    </div>
</template>

<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import Button from '@/components/Button.vue';
import CatalogFilters from '@/components/catalog/CatalogFilters.vue';
import CatalogHero from '@/components/catalog/CatalogHero.vue';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
import ProductCard from '@/components/product/ProductCard.vue';
import SearchInput from '@/components/SearchInput.vue';
import Select from '@/components/Select.vue';
import { useBodyScrollLock } from '@/composables/useBodyScrollLock';
import AppLayout from '@/layouts/AppLayout.vue';
import { home as HomeIndex } from '@/routes';
import { index as CatalogIndex } from '@/routes/catalog';
import type { Category } from '@/types/category.ts';
import type { Page } from '@/types/pagination.ts';
import type { Product} from '@/types/product.ts';
import  { ProductSearchSort } from '@/types/product.ts';

defineOptions({ layout: AppLayout });

interface Props {
    minPrice: number,
    maxPrice: number,
    categories: Category[],
    productsPage: Page<Product>,
}

const props = defineProps<Props>();

const getQueryParam = (key: string): string | null => {
    if (typeof window === 'undefined') {

        return null;
    }

    return new URLSearchParams(window.location.search).get(key);
};

const getInitialSearchQuery = (): string => {
    const param = getQueryParam('name');

    return param ?? '';
};

const getInitialCategories = (): string[] => {
    const param = getQueryParam('categories');

    return param ? param.split(',') : [];
};

const getInitialSort = (): string => {
    const param = getQueryParam('sort');

    return param && Object.values(ProductSearchSort).includes(param as ProductSearchSort)
        ? param
        : ProductSearchSort.SORT;
};

const getInitialInStock = (): boolean => {
    return getQueryParam('in_stock') !== '0';
};

const getInitialNumber = (key: string, defaultValue: number): number => {
    const param = getQueryParam(key);

    if (param === null || param === '') {

        return defaultValue;
    }

    const parsed = Number(param);

    return Number.isNaN(parsed) ? defaultValue : parsed;
};

const allCategories = computed(() => {
    return props.categories.map((category) => {
        return {
            alias: category.alias,
            name: category.name,
            active: selectedCategories.value.includes(category.alias),
        };
    });
});

const filteredProducts = computed(() => props.productsPage?.items ?? []);

const sortItems = [
    { label: 'Сначала популярные', value: ProductSearchSort.SORT },
    { label: 'Цена: по возрастанию', value: ProductSearchSort.PRICE_ASC },
    { label: 'Цена: по убыванию', value: ProductSearchSort.PRICE_DESC },
];
const productsSort = ref(getInitialSort());
const searchQuery = ref(getInitialSearchQuery());
const filtersOpen = ref(false);
const selectedCategories = ref<string[]>(getInitialCategories());
const minPrice = ref(getInitialNumber('price_from', props.minPrice));
const maxPrice = ref(getInitialNumber('price_to', props.maxPrice));
const onlyInStock = ref(getInitialInStock());

const activeFiltersCount = computed(
    () =>
        selectedCategories.value.length +
        (minPrice.value > props.minPrice ? 1 : 0) +
        (maxPrice.value < props.maxPrice ? 1 : 0) +
        (!onlyInStock.value ? 1 : 0),
);

let debounceTimer: ReturnType<typeof setTimeout> | null = null;

const applyFilters = () => {
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }

    debounceTimer = setTimeout(() => {
        router.get(
            window.location.pathname,
            {
                name: searchQuery.value.length > 0
                    ? searchQuery.value
                    : undefined,
                categories: selectedCategories.value.length > 0
                    ? selectedCategories.value.join(',')
                    : undefined,
                in_stock: !onlyInStock.value ? 0 : undefined,
                sort: productsSort.value !== ProductSearchSort.SORT
                    ? productsSort.value
                    : undefined,
                price_from: minPrice.value > props.minPrice ? minPrice.value : undefined,
                price_to: maxPrice.value < props.maxPrice ? maxPrice.value : undefined,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                only: ['productsPage'],
            }
        );
    }, 300);
};

watch(
    [searchQuery, selectedCategories, onlyInStock, productsSort, minPrice, maxPrice],
    applyFilters,
    { deep: true }
);

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
    searchQuery.value = '';
    selectedCategories.value = [];
    minPrice.value = props.minPrice;
    maxPrice.value = props.maxPrice;
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

<style lang="scss" scoped>
.catalog-index-products-enter-active,
.catalog-index-products-leave-active,
.catalog-index-products-move {
    transition: all 1s cubic-bezier(0.25, 1, 0.5, 1);
}

.catalog-index-products-enter-from,
.catalog-index-products-leave-to {
    opacity: 0;
    transform: translateY(6px);
}

.catalog-index-products-leave-active {
    pointer-events: none;
    position: absolute;
}

.catalog-index-fade-enter-active,
.catalog-index-fade-leave-active {
    transition:
        opacity 0.35s cubic-bezier(0.25, 1, 0.5, 1),
        transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
}

.catalog-index-fade-enter-from,
.catalog-index-fade-leave-to {
    opacity: 0;
    transform: translateY(6px);
}

.catalog-index-overlay-enter-active,
.catalog-index-overlay-leave-active {
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.catalog-index-overlay-enter-from,
.catalog-index-overlay-leave-to {
    opacity: 0;
}
.catalog-index-drawer-enter-active {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.catalog-index-drawer-leave-active {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.catalog-index-drawer-enter-from,
.catalog-index-drawer-leave-to {
    transform: translateY(100%);
}
.catalog-index-drawer-enter-to {
    transform: translateY(0);
}
</style>

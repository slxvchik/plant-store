<template>
    <div class="catalog-index">
        <Container class="catalog-index__container">
            <Breadcrumbs
                :items="[
                    { url: home.url(), name: 'Главная' },
                    { url: home.url(), name: 'Каталог' },
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
                                v-model:categories="selectedCategories"
                                v-model:in-stock="onlyInStock"
                                v-model:max-price="maxPrice"
                                v-model:min-price="minPrice"
                                :max-price-base="7000"
                                :min-price-base="0"
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
                        <div v-else class="catalog-index__empty">
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
                                v-model:categories="selectedCategories"
                                v-model:in-stock="onlyInStock"
                                v-model:max-price="maxPrice"
                                v-model:min-price="minPrice"
                                :max-price-base="7000"
                                :min-price-base="0"
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
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
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
import { home } from '@/routes';
import type { ProductListItem } from '@/types/product.ts';

defineOptions({ layout: AppLayout });

const sortItems = [
    { label: 'Сначала популярные', value: 'popularity' },
    { label: 'Цена: по возрастанию', value: 'price-big' },
    { label: 'Цена: по убыванию', value: 'price-small' },
];
const productsSort = ref('popularity');
const searchQuery = ref('');
const filtersOpen = ref(false);
const selectedCategories = ref<string[]>([]);
const minPrice = ref(0);
const maxPrice = ref(7000);
const onlyInStock = ref(true);

const activeFiltersCount = computed(
    () =>
        selectedCategories.value.length +
        (maxPrice.value < 7000 ? 1 : 0) +
        (onlyInStock.value ? 1 : 0),
);
const filteredProducts = ref<ProductListItem[]>([]);
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
    minPrice.value = 0;
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

.catalog-index-overlay-enter-active,
.catalog-index-overlay-leave-active {
    @apply transition-opacity duration-300;
}
.catalog-index-overlay-enter-from,
.catalog-index-overlay-leave-to {
    @apply opacity-0;
}
.catalog-index-drawer-enter-active {
    @apply transform-gpu transition-transform duration-500 ease-out;
}
.catalog-index-drawer-leave-active {
    @apply transform-gpu transition-transform duration-300 ease-in;
}
.catalog-index-drawer-enter-from,
.catalog-index-drawer-leave-to {
    @apply translate-y-full;
}
.catalog-index-drawer-enter-to {
    @apply translate-y-0;
}
</style>

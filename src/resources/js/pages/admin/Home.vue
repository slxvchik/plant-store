<template>
    <div class="admin-home">
        <div class="admin-home__hero">
            <p class="admin-home__eyebrow">Панель управления</p>
            <h1 class="admin-home__title">Деулино Сад</h1>
            <p class="admin-home__description">
                Каталог, складские единицы, закупки и заказы — в едином рабочем
                пространстве.
            </p>
        </div>
        <div class="admin-home__grid">
            <a
                v-for="card in cards"
                :key="card.href"
                :class="cardClasses(card.tone)"
                :href="card.href"
            >
                <span :class="iconClasses(card.tone)">{{ card.letter }}</span>
                <h2 class="admin-home__card-title">{{ card.title }}</h2>
                <p class="admin-home__card-description">{{ card.description }}</p>
                <p class="admin-home__card-link">Перейти →</p>
            </a>
        </div>
    </div>
</template>
<script lang="ts" setup>
import AdminLayout from '@/layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });
const cards = [
    {
        href: '/admin/products',
        letter: 'К',
        title: 'Каталог',
        description: 'Товары, категории и торговые предложения.',
        tone: 'emerald',
    },
    {
        href: '/admin/product-units',
        letter: 'Е',
        title: 'Единицы товара',
        description: 'Поштучный учёт, статусы и генерация партий.',
        tone: 'sky',
    },
    {
        href: '/admin/product-supplies',
        letter: 'П',
        title: 'Поставки',
        description: 'Приёмка товара и автоматическое создание единиц.',
        tone: 'violet',
    },
    {
        href: '/admin/orders',
        letter: 'З',
        title: 'Заказы',
        description: 'Обработка заказов и контроль выполнения.',
        tone: 'amber',
    },
];
const cardClasses = (tone: string) => ['admin-home__card', `admin-home__card--${tone}`];
const iconClasses = (tone: string) => [
    'admin-home__card-icons',
    `admin-home__card-icon--${tone}`,
];
</script>

<template>
    <a class="blog-card" href="#journal">
        <div class="blog-card__image-wrap">
            <img
                :alt="article.title"
                :src="article.image"
                class="blog-card__image"
                loading="lazy"
            />
        </div>
        <div class="blog-card__meta">
            <time>{{ article.date }}</time>
            <span class="blog-card__separator">·</span>
            <p>{{ article.readTime }} чтения</p>
        </div>
        <h3 class="blog-card__title">{{ article.title }}</h3>
        <p class="blog-card__excerpt">{{ article.excerpt }}</p>
        <span class="blog-card__link">
            Читать статью
            <span class="blog-card__link-icon"><Icon name="arrow" /></span>
        </span>
    </a>
</template>
<script lang="ts" setup>
import Icon from '@/components/icons/Icon.vue';

type Article = {
    title: string;
    excerpt: string;
    date: string;
    readTime: string;
    image: string;
};
withDefaults(defineProps<{ article?: Article }>(), {
    article: () => ({
        title: 'Когда растению пора переселяться?',
        excerpt:
            'Пять ненавязчивых сигналов, которые подаёт корневая система, и как выбрать новый горшок.',
        date: '21 октября 2026',
        readTime: '4 мин',
        image: '/images/blog_1.png',
    }),
});
</script>

<template>
    <a href="#journal" class="group block h-full">
        <div
            class="aspect-[4/3] overflow-hidden rounded-[24px] bg-bg-base dark:bg-bg-night"
        >
            <img
                :src="article.image"
                :alt="article.title"
                loading="lazy"
                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
            />
        </div>
        <div
            class="mt-4 flex items-center gap-2 text-xs text-text-muted dark:text-white/45"
        >
            <time>{{ article.date }}</time
            ><span class="text-accent">·</span>
            <p>{{ article.readTime }} чтения</p>
        </div>
        <h3
            class="mt-3 font-serif text-2xl leading-tight text-text-title transition-colors duration-300 group-hover:text-primary dark:text-linen dark:group-hover:text-secondary"
        >
            {{ article.title }}
        </h3>
        <p class="mt-2 text-sm leading-6 text-text-muted dark:text-white/50">
            {{ article.excerpt }}
        </p>
        <span
            class="mt-4 flex min-h-11 w-fit items-center gap-2 text-sm font-semibold text-primary dark:text-secondary"
            >Читать статью<span
                class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                ><AppIcon name="arrow" /></span
        ></span>
    </a>
</template>

<script setup lang="ts">
import AppIcon from '@/components/AppIcon.vue';

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

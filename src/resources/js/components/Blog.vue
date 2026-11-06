<template>
    <section
        id="journal"
        class="scroll-mt-24 bg-bg-surface px-4 py-16 md:px-8 md:py-24 dark:bg-bg-night-soft"
    >
        <div class="mx-auto max-w-[1440px]">
            <Reveal>
                <div
                    class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between"
                >
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.2em] text-accent uppercase"
                        >
                            Садовый журнал
                        </p>
                        <h2
                            class="mt-3 font-serif text-3xl text-text-title md:text-4xl lg:text-5xl dark:text-linen"
                        >
                            Знания, которые растут<br class="hidden md:block" />
                            вместе с вами
                        </h2>
                    </div>
                    <a
                        href="#journal"
                        class="group flex min-h-11 w-fit items-center gap-2 text-sm font-semibold text-primary dark:text-secondary"
                        >Все статьи<span
                            class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                            ><AppIcon name="arrow" /></span
                    ></a>
                </div>
            </Reveal>
            <div
                class="mt-9 grid gap-8 md:mt-12 md:grid-cols-3 md:gap-5 lg:gap-8"
            >
                <Reveal
                    v-for="(article, index) in articles"
                    :key="article.title"
                    :delay="index * 100"
                    ><BlogCard :article="article"
                /></Reveal>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import AppIcon from '@/components/AppIcon.vue';
import BlogCard from '@/components/BlogCard.vue';
import Reveal from '@/components/Reveal.vue';

const articles = [
    {
        title: 'Когда растению пора переселяться?',
        excerpt:
            'Пять ненавязчивых сигналов, которые подаёт корневая система, и как выбрать новый горшок.',
        date: '21 октября 2026',
        readTime: '4 мин',
        image: '/images/blog_1.png',
    },
    {
        title: 'Мягкий свет для зелёных любимцев',
        excerpt:
            'Разбираемся в рассеянном свете и находим подходящее место даже в тёмной квартире.',
        date: '12 октября 2026',
        readTime: '6 мин',
        image: '/images/slide_1.avif',
    },
    {
        title: 'Полив без расписания и тревоги',
        excerpt:
            'Почему важнее наблюдать за растением, чем следовать календарю, и с чего начать.',
        date: '3 октября 2026',
        readTime: '5 мин',
        image: '/images/water-lily.png',
    },
];
</script>

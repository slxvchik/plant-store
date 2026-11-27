<template>
    <section id="journal" class="blog">
        <Container>
            <Reveal>
                <div class="blog__header">
                    <div>
                        <p class="blog__eyebrow">Садовый журнал</p>
                        <h2 class="blog__title">
                            Знания, которые растут
                            <br class="blog__title-break" />
                            вместе с вами
                        </h2>
                    </div>
                    <a class="blog__all" href="#journal">
                        Все статьи
                        <span class="blog__all-icon">
                            <Icon name="arrow" />
                        </span>
                    </a>
                </div>
            </Reveal>
            <div class="blog__grid">
                <Reveal
                    v-for="(article, index) in articles"
                    :key="article.title"
                    :delay="index * 100"
                >
                    <BlogCard :article="article" />
                </Reveal>
            </div>
        </Container>
    </section>
</template>
<script lang="ts" setup>
import BlogCard from '@/components/blog/BlogCard.vue';
import Container from '@/components/Container.vue';
import Icon from '@/components/icons/Icon.vue';
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

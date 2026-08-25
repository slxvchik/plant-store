<script setup lang="ts">
import BlogCard from '@/components/BlogCard.vue';
</script>

<template>
    <section class="bg-bg-1 px-3 py-8 md:px-8 md:py-20 xl:px-20 xl:py-25">
        <h2 class="text font-serif font-bold text-accent uppercase">
            Садовый журнал
        </h2>
        <p
            class="mt-3 font-sans text-4xl leading-[1.1] font-light whitespace-pre-line text-main sm:text-5xl lg:text-6xl"
        >
            Воплощение мудрости и заботы
        </p>
        <p class="mt-3 font-sans text-muted sm:text-lg">
            Ознакомьтесь с нашими ежемесячными публикациями о садоводстве, в
            которых наши ботаники делятся накопленными знаниями и практическими
            рекомендациями.
        </p>

        <a
            href="/blog"
            class="mt-6 ml-auto flex w-fit text-muted transition-all duration-300 hover:text-muted-hover"
        >
            Читать все
        </a>

        <!-- only 3 element -->
        <div class="mt-2 grid w-full grid-cols-1 gap-4 md:grid-cols-3 md:gap-6">
            <BlogCard v-for="n in 3" :key="n" />
        </div>
    </section>
</template>

<style scoped></style>

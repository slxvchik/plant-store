<template>
    <section
        class="overflow-hidden bg-bg-base px-4 py-16 md:px-8 md:py-24 lg:py-28 dark:bg-bg-night"
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
                            Выбор наших садоводов
                        </p>
                        <h2
                            class="mt-3 font-serif text-3xl leading-tight text-text-title md:text-4xl lg:text-5xl dark:text-linen"
                        >
                            Растения, которые<br class="hidden md:block" />
                            легко полюбить
                        </h2>
                    </div>
                    <div class="max-w-md">
                        <p
                            class="text-sm leading-6 text-text-muted md:text-base dark:text-white/50"
                        >
                            Здоровая корневая система, выразительная листва и
                            адаптация к домашним условиям.
                        </p>
                        <Link
                            href="/catalog"
                            class="group mt-4 flex min-h-11 w-fit items-center gap-2 text-sm font-semibold text-primary dark:text-secondary"
                            >Смотреть весь каталог<span
                                class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                ><AppIcon name="arrow" /></span
                        ></Link>
                    </div>
                </div>
            </Reveal>
            <Reveal :delay="120" class="mt-8 md:mt-12"
                ><ProductSlider
            /></Reveal>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppIcon from '@/components/AppIcon.vue';
import ProductSlider from '@/components/product/ProductSlider.vue';
import Reveal from '@/components/Reveal.vue';
</script>

<template>
    <section
        id="delivery"
        class="bg-bg-surface px-4 py-16 md:px-8 md:py-24 dark:bg-bg-night-soft"
    >
        <Container>
            <Reveal>
                <div class="max-w-2xl">
                    <p
                        class="text-xs font-semibold tracking-[0.2em] text-primary uppercase dark:text-secondary"
                    >
                        Больше, чем доставка
                    </p>
                    <h2
                        class="mt-3 font-serif text-3xl leading-tight text-text-title md:text-4xl lg:text-5xl dark:text-linen"
                    >
                        Забота продолжается
                        <br />
                        и после покупки
                    </h2>
                </div>
            </Reveal>
            <div
                class="mt-9 grid grid-cols-1 gap-4 md:mt-12 md:grid-cols-2 lg:auto-rows-[250px] lg:grid-cols-12 lg:gap-5"
            >
                <Reveal class="md:col-span-2 lg:col-span-7 lg:row-span-2">
                    <article
                        class="group relative h-full min-h-[420px] overflow-hidden rounded-[28px] lg:min-h-full"
                    >
                        <img
                            alt="Садовод заботится о растениях"
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105"
                            loading="lazy"
                            src="/images/slide_1.avif"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-bg-dark/90 via-bg-dark/20 to-transparent"
                        />
                        <div
                            class="absolute inset-x-0 bottom-0 p-6 text-white md:p-8 lg:p-10"
                        >
                            <span
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-white/15 backdrop-blur"
                            >
                                <span class="h-5 w-5">
                                    <AppIcon name="leaf" />
                                </span>
                            </span>
                            <h3 class="mt-5 font-serif text-3xl md:text-4xl">
                                Подбор с пониманием
                            </h3>
                            <p
                                class="mt-3 max-w-md text-sm leading-6 text-white/70 md:text-base"
                            >
                                Учтём освещение, влажность и ваш ритм жизни. Не
                                просто продадим растение — поможем найти именно
                                ваше.
                            </p>
                        </div>
                    </article>
                </Reveal>
                <Reveal :delay="100" class="lg:col-span-5">
                    <article
                        class="flex h-full min-h-[240px] flex-col justify-between rounded-[28px] bg-primary p-6 text-white transition-all duration-300 hover:shadow-xl md:p-8 dark:bg-primary/80"
                    >
                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-white/10"
                        >
                            <span class="h-5 w-5">
                                <AppIcon name="truck" />
                            </span>
                        </span>
                        <div class="mt-8">
                            <p class="font-serif text-2xl md:text-3xl">
                                Бережная доставка
                            </p>
                            <p class="mt-2 text-sm leading-6 text-white/65">
                                Отправляем по всей Московской области.
                            </p>
                        </div>
                    </article>
                </Reveal>
                <Reveal :delay="180" class="lg:col-span-2">
                    <article
                        class="flex h-full min-h-[220px] flex-col justify-between rounded-[28px] border border-text-title/5 bg-bg-elevated p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-white/10 dark:bg-bg-night"
                    >
                        <span
                            class="text-xs font-semibold tracking-widest text-accent uppercase"
                        >
                            Нам доверяют
                        </span>
                        <div>
                            <p
                                class="font-serif text-5xl text-text-title dark:text-linen"
                            >
                                12
                                <span class="text-primary dark:text-secondary">
                                    +
                                </span>
                            </p>
                            <p
                                class="mt-1 text-sm text-text-muted dark:text-white/50"
                            >
                                лет выращиваем
                                <br />
                                с любовью
                            </p>
                        </div>
                    </article>
                </Reveal>
                <Reveal :delay="240" class="lg:col-span-3">
                    <article
                        class="flex h-full min-h-[220px] flex-col justify-between rounded-[28px] bg-[#d9cbbb] p-6 text-bg-dark transition-all duration-300 hover:-translate-y-1 hover:shadow-lg dark:bg-[#9b8975]"
                    >
                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-white/35"
                        >
                            <span class="h-5 w-5">
                                <AppIcon name="shield" />
                            </span>
                        </span>
                        <div>
                            <p class="font-serif text-2xl">30 дней гарантии</p>
                            <p class="mt-2 text-sm leading-6 opacity-70">
                                Остаёмся на связи.
                            </p>
                        </div>
                    </article>
                </Reveal>
            </div>
        </Container>
    </section>
</template>

<script lang="ts" setup>
import AppIcon from '@/components/AppIcon.vue';
import Reveal from '@/components/Reveal.vue';
import Container from '@/components/Container.vue';
</script>

<template>
    <section
        id="mission"
        class="scroll-mt-20 bg-bg-dark px-4 py-16 md:px-8 md:py-24 lg:py-28"
    >
        <div
            class="mx-auto grid max-w-[1440px] items-center gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-20"
        >
            <Reveal direction="right">
                <div class="relative">
                    <div
                        class="aspect-[4/5] max-h-[640px] overflow-hidden rounded-[28px] rounded-tr-[100px] md:rounded-tr-[160px]"
                    >
                        <img
                            src="/images/water_lily.png"
                            alt="Цветущее растение в оранжерее Деулино"
                            loading="lazy"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div
                        class="absolute right-4 bottom-4 rounded-2xl border border-white/20 bg-bg-dark/60 px-5 py-4 text-white backdrop-blur-md md:right-8 md:bottom-8"
                    >
                        <p class="font-serif text-3xl text-secondary">2 400+</p>
                        <p class="mt-1 text-xs text-white/60">
                            растений обрели дом в этом году
                        </p>
                    </div>
                </div>
            </Reveal>
            <Reveal direction="left" :delay="100">
                <p
                    class="text-xs font-semibold tracking-[0.2em] text-secondary uppercase"
                >
                    Наша миссия
                </p>
                <h2
                    class="mt-4 font-serif text-3xl leading-tight text-linen md:text-4xl lg:text-5xl"
                >
                    Помогаем людям<br />и растениям
                    <em class="text-secondary">расти вместе</em>
                </h2>
                <p
                    class="mt-5 max-w-lg text-sm leading-7 text-white/55 md:text-base"
                >
                    Мы верим, что забота о живом начинается с внимания. Поэтому
                    знаем историю каждого растения и говорим честно об уходе,
                    условиях и возможных сложностях.
                </p>
                <ul class="mt-8 space-y-5">
                    <li
                        v-for="(item, index) in principles"
                        :key="item.title"
                        class="flex gap-4"
                    >
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/5 font-serif text-secondary"
                            >0{{ index + 1 }}</span
                        >
                        <div>
                            <h3 class="font-medium text-white">
                                {{ item.title }}
                            </h3>
                            <p class="mt-1 text-sm leading-6 text-white/45">
                                {{ item.text }}
                            </p>
                        </div>
                    </li>
                </ul>
            </Reveal>
        </div>
    </section>
</template>

<script setup lang="ts">
import Reveal from '@/components/Reveal.vue';

const principles = [
    {
        title: 'Живые растения, а не конвейер',
        text: 'Выращиваем в собственных оранжереях и отбираем каждый экземпляр вручную.',
    },
    {
        title: 'Экологичность без громких обещаний',
        text: 'Используем возобновляемую энергию, биологическую защиту и перерабатываемую упаковку.',
    },
    {
        title: 'Поддержка на каждом этапе',
        text: 'Делимся знаниями и остаёмся на связи после того, как растение переехало к вам.',
    },
];
</script>
